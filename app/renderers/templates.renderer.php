<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com> and Matthias Leuffen http://leuffen.de - https://github.com/dermatthes
 * @copyright  2016 vonUbisch.com and leuffen.de
 */
class TemplatesRenderer extends Renderer {

    private $variable = '{% * }';
    private $mTemplateText;
    private $mFilter = [];
    private $mConf = [
        "varStartTag" => "{=",
        "varEndTag" => "}",
        "comStartTag" => "{",
        "comEndTag" => "}"
    ];

    public function run($options) {
        
    }

    public function layout($name, $callback) {
        $contents = $this->getFile($name);
        $contents = $this->replace(__FUNCTION__, $callback(), $contents, $this->variable);
        $this->mTemplateText .= $contents;
    }

    public function container($name, $callback) {
        $contents = $this->getFile($name);
        $contents = $this->replace(__FUNCTION__, $callback(), $contents, $this->variable);
        return $contents;
    }

    public function loadTemplate($template) {
        return $this->getFile($template);
    }

    /**
     * Parse Tokens in Text (Search for $(name.subname.subname)) of
     *
     *
     * @return string
     */
    public function apply($params, $softFail = TRUE) {
        $this->parse();
        $text = $this->mTemplateText;
        $context = $params;
        $text = $this->_replaceNestingLevels($text);
        $text = $this->_parseBlock($context, $text, $softFail);
        $result = $this->_parseValueOfTags($context, $text, $softFail);
        return $result;
    }

    public function parse() {
        $this->mFilter["_DEFAULT_"] = function ($input) {
            return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        };
        // Raw is only a pseudo-filter. If it is not in the chain of filters, __DEFAULT__ will be appended to the filter
        $this->mFilter["html"] = function ($input) {
            return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        };
        $this->mFilter["raw"] = function ($input) {
            return $input;
        };
        $this->mFilter["uppercase"] = function ($input) {
            return strtoupper($input);
        };

        $this->mFilter["link"] = function ($input) {
            return Router::generate($input);
        };

        $this->mFilter["dump"] = function ($input) {
            return print_r($input, true);
        };

        $this->mFilter["singleLine"] = function ($input) {
            return str_replace("\n", " ", $input);
        };
        $this->mFilter["inivalue"] = function ($input) {
            return addslashes(str_replace("\n", " ", $input));
        };
    }

    /**
     * Set the default Filter
     *
     * @param $filterName
     */
    public function setDefaultFilter($filterName) {
        $this->mFilter["_DEFAULT_"] = $this->mFilter[$filterName];
    }

    /**
     * Add a user-defined filter function to the list of available filters.
     *
     * A filter function must accept at least one parameter: input and return the resulting
     * value.
     *
     * Example:
     *
     * addFilter("currency", function (input) {
     *      return number_format ($input, 2, ",", ".");
     * });
     *
     * @param $filterName
     * @param callable $filterFn
     * @return $this
     */
    public function addFilter($filterName, callable $filterFn) {
        $this->mFilter[$filterName] = $filterFn;
        return $this;
    }

    /**
     * Tag-Nesting is done by initially adding an index to both the opening and the
     * closing tag. (By the way some cleanup is done)
     *
     * Example
     *
     * {if xyz}
     * {/if}
     *
     * Becomes:
     *
     * {if0 xyz}
     * {/if0}
     *
     * This trick makes it possible to add tag nesting functionality
     *
     *
     * @param $input
     * @return mixed
     * @throws RendererException
     */
    public function _replaceNestingLevels($input) {
        $indexCounter = 0;
        $nestingIndex = [];
        $lines = explode("\n", $input);
        for ($li = 0; $li < count($lines); $li++) {
            $lines[$li] = preg_replace_callback('/\{(?!=)\s*(\/?)\s*([a-z]+)(.*?)\}/im', function ($matches) use (&$nestingIndex, &$indexCounter, &$li) {
                $slash = $matches[1];
                $tag = $matches[2];
                $rest = $matches[3];
                if ($slash == "") {
                    if (!isset($nestingIndex[$tag]))
                        $nestingIndex[$tag] = [];
                    $nestingIndex[$tag][] = [$indexCounter, $li];
                    $out = "{" . $tag . $indexCounter . rtrim($rest) . "}";
                    $indexCounter++;
                    return $out;
                } else if ($slash == "/") {
                    if (!isset($nestingIndex[$tag])) {
                        throw new RendererException("Line {$li}: Opening tag not found for closing tag: '{$matches[0]}'");
                    }
                    if (count($nestingIndex[$tag]) == 0) {
                        throw new RendererException("Line {$li}: Nesting level does not match for closing tag: '{$matches[0]}'");
                    }
                    $curIndex = array_pop($nestingIndex[$tag]);
                    return "{/" . $tag . $curIndex[0] . "}";
                } else {
                    throw new RendererException("Line {$li}: This exception should not appear!");
                }
            }, $lines[$li]
            );
        }
        foreach ($nestingIndex as $tag => $curNestingIndex) {
            if (count($curNestingIndex) > 0)
                throw new RendererException("Unclosed tag '{$tag}' opened in line {$curNestingIndex[0][1]} ");
        }
        return implode("\n", $lines);
    }

    private function _getValueByName($context, $name, $softFail = TRUE) {
        $dd = explode(".", $name);
        $value = $context;
        $cur = "";
        foreach ($dd as $cur) {
            if (is_array($value)) {
                if (!isset($value[$cur])) {
                    $value = NULL;
                } else {
                    $value = $value[$cur];
                }
            } else {
                if (is_object($value)) {
                    if (!isset($value->$cur)) {
                        $value = NULL;
                    } else {
                        $value = $value->$cur;
                    }
                } else {
                    if (!$softFail) {
                        throw new RendererException("ParsingError: Can't parse element: '{$name}' Error on subelement: '$cur'");
                    }
                    $value = NULL;
                }
            }
        }
        if (is_object($value) && !method_exists($value, "__toString")) {
            $value = "##ERR:OBJECT_IN_TEXT:[{$name}]ON[{$cur}]:" . gettype($value) . "###";
        }
        return $value;
    }

    private function _parseValueOfTags($context, $block, $softFail = TRUE) {
        $result = preg_replace_callback("/\\{=(.+?)\\}/im", function ($_matches) use ($softFail, $context) {
            $match = $_matches[1];
            $chain = explode("|", $match);
            for ($i = 0; $i < count($chain); $i++)
                $chain[$i] = trim($chain[$i]);
            if (!in_array("raw", $chain))
                $chain[] = "_DEFAULT_";
            $varName = trim(array_shift($chain));
            if ($varName === "__CONTEXT__") {
                $value = "\n----- __CONTEXT__ -----\n" . var_export($context, true) . "\n----- / __CONTEXT__ -----\n";
            } else {
                $value = $this->_getValueByName($context, $varName, $softFail);
            }
            foreach ($chain as $curName) {
                if (!isset($this->mFilter[$curName]))
                    throw new RendererException("Filter '$curName' not defined");
                $fn = $this->mFilter[$curName];
                $value = $fn($value);
            }
            return $value;
        }, $block);
        return $result;
    }

    private function _runFor($context, $content, $cmdParam, $softFail = TRUE) {
        if (!preg_match('/([a-z0-9\.\_]+) in ([a-z0-9\.\_]+)/i', $cmdParam, $matches)) {
            
        }
        $iterateOverName = $matches[2];
        $localName = $matches[1];
        $repeatVal = $this->_getValueByName($context, $iterateOverName, $softFail);
        if (!is_array($repeatVal))
            return "";
        $index = 0;
        $result = "";
        foreach ($repeatVal as $key => $curVal) {
            $context[$localName] = $curVal;
            $context["@key"] = $key;
            $context["@index0"] = $index;
            $context["@index1"] = $index + 1;
            $curContent = $this->_parseBlock($context, $content, $softFail);
            $curContent = $this->_parseValueOfTags($context, $curContent, $softFail);
            $result .= $curContent;
            $index++;
        }
        return $result;
    }

    private function _getItemValue($compName, $context) {
        if (preg_match('/^("|\')(.*?)\1$/i', $compName, $matches))
            return $matches[2]; // string Value
        if (is_numeric($compName))
            return ($compName);
        if (strtoupper($compName) == "FALSE")
            return FALSE;
        if (strtoupper($compName) == "TRUE")
            return TRUE;
        if (strtoupper($compName) == "NULL")
            return NULL;
        return $this->_getValueByName($context, $compName);
    }

    private function _runIf($context, $content, $cmdParam, $softFail = TRUE) {
        //echo $cmdParam;
        if (!preg_match('/([\"\']?.*?[\"\']?)\s*(==|<|>|!=)\s*([\"\']?.*[\"\']?)/i', $cmdParam, $matches))
            return "!! Invalid command sequence: '$cmdParam' !!";
        //print_r ($matches);
        $comp1 = $this->_getItemValue(trim($matches[1]), $context);
        $comp2 = $this->_getItemValue(trim($matches[3]), $context);
        //decho $comp1 . $comp2;
        $doIf = FALSE;
        switch ($matches[2]) {
            case "==":
                $doIf = ($comp1 == $comp2);
                break;
            case "!=":
                $doIf = ($comp1 != $comp2);
                break;
            case "<":
                $doIf = ($comp1 < $comp2);
                break;
            case ">":
                $doIf = ($comp1 > $comp2);
                break;
        }
        if (!$doIf)
            return "";
        $content = $this->_parseBlock($context, $content, $softFail);
        $content = $this->_parseValueOfTags($context, $content, $softFail);
        return $content;
    }

    private function _runTest($context, $content, $cmdParam, $softFail = TRUE) {
        Debug::dump(func_get_args());
    }

    private function _parseBlock($context, $block, $softFail = TRUE) {
        // (?!\{): Lookahead Regex: Don't touch double {{
        $result = preg_replace_callback('/\n?\{(?!=)(([a-z]+)[0-9]+)(.*?)\}(.*?)\n?\{\/\1\}/ism', function ($matches) use ($context, $softFail) {
            $command = $matches[2];
            $cmdParam = $matches[3];
            $content = $matches[4];
            switch ($command) {
                case "for":
                    return $this->_runFor($context, $content, $cmdParam, $softFail);
                case "if":
                    return $this->_runIf($context, $content, $cmdParam, $softFail);
                default:
                    return "!! Invalid command: '$command' !!";
            }
        }, $block);
        if ($result === NULL) {
            throw new RendererException("preg_replace_callback() returned NULL: preg_last_error() returns: " . preg_last_error() . " (error == 2: preg.backtracklimit to low)");
        }
        return $result;
    }

    private function replace($search, $replace, $subject, $variable) {
        return str_replace(str_replace('*', $search, $variable), $replace, $subject);
    }

    private function getFile($file) {
        $path = $this->path($file);
        if (!file_exists($path)):
            throw new RendererException(Exceptions::FILENOTFOUND . $file);
        endif;
        return file_get_contents($path);
    }

    private function path($file) {
        return Configuration::path('public', $file);
    }

}
