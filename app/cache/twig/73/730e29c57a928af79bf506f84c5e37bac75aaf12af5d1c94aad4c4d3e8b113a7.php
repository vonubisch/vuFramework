<?php

/* layouts/layout.html */
class __TwigTemplate_d8630ead2efdab4b0995e9b39099313fee7094c078b2bf6addf1661181e1809b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<!--                  __  __  __                         __                                      
                     /\\ \\/\\ \\/\\ \\      __               /\\ \\                                     
  __  __   ___    ___\\ \\ \\ \\ \\ \\ \\____/\\_\\    ____   ___\\ \\ \\___        ___    ___    ___ ___    
 /\\ \\/\\ \\ / __`\\/' _ `\\ \\ \\ \\ \\ \\ '__`\\/\\ \\  /',__\\ /'___\\ \\  _ `\\     /'___\\ / __`\\/' __` __`\\  
 \\ \\ \\_/ /\\ \\_\\ \\\\ \\/\\ \\ \\ \\_\\ \\ \\ \\_\\ \\ \\ \\/\\__, `/\\ \\__/\\ \\ \\ \\ \\ __/\\ \\__//\\ \\_\\ \\\\ \\/\\ \\/\\ \\ 
  \\ \\___/\\ \\____/ \\_\\ \\_\\ \\_____\\ \\____/\\ \\_\\/\\____\\ \\____\\\\ \\_\\ \\_/\\_\\ \\____\\ \\____/ \\_\\ \\_\\ \\_\\
   \\/__/  \\/___/ \\/_/\\/_/\\/_____/\\/___/  \\/_/\\/___/ \\/____/ \\/_/\\/_\\/_/\\/____/\\/___/ \\/_/\\/_/\\/_/

-->
<html lang=\"\">
    <head>
        <meta charset=\"utf-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <meta name=\"description\" content=\"\">
        <meta name=\"keywords\" content=\"\">
        <meta name=\"author\" content=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "application", array()), "author", array()), "html", null, true);
        echo "\">
        <meta name=\"application-name\" content=\"vuApplication\">
        <meta name=\"msapplication-TileColor\" content=\"#000000\">
        <meta name=\"theme-color\" content=\"#999999\">
        <meta property=\"og:site_name\" content=\"\">
        <meta property=\"og:url\" content=\"\">
        <meta property=\"og:title\" content=\"\">
        <meta property=\"og:type\" content=\"\">
        <meta property=\"og:image\" content=\"\">
        <meta property=\"og:video\" content=\"\">
        <meta property=\"og:audio\" content=\"\">
        <meta property=\"og:description\" content=\"\">
        <meta property=\"fb:app_id\" content=\"\">
        <meta name=\"twitter:card\" content=\"\">
        <meta name=\"twitter:site\" content=\"\">
        <meta name=\"twitter:title\" content=\"\">
        <meta name=\"twitter:description\" content=\"\">
        <meta name=\"twitter:image\" content=\"\">
        <title>";
        // line 36
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "application", array()), "name", array()), "html", null, true);
        echo "</title>
        <base href=\"";
        // line 37
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "enviroment", array()), "base", array()), "html", null, true);
        echo "\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css\">
        <link rel=\"icon\" href=\"assets/img/favicon/favicon.ico\">
        <link rel=\"apple-touch-icon\" href=\"assets/img/favicon/favicon.png\">
        <link rel=\"author\" type=\"text/plain\" href=\"humans.txt\">
        <!--[if lt IE 9]>
          <script src=\"https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js\"></script>
          <script src=\"https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js\"></script>
        <![endif]-->
    </head>
    ";
        // line 48
        echo twig_escape_filter($this->env, (isset($context["test"]) ? $context["test"] : null), "html", null, true);
        echo "
    <body>
        <script src=\"//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js\"></script>
        <script src=\"//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js\"></script>
    </body>
</html>";
    }

    public function getTemplateName()
    {
        return "layouts/layout.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  77 => 48,  63 => 37,  59 => 36,  38 => 18,  19 => 1,);
    }

    public function getSource()
    {
        return "<!DOCTYPE html>
<!--                  __  __  __                         __                                      
                     /\\ \\/\\ \\/\\ \\      __               /\\ \\                                     
  __  __   ___    ___\\ \\ \\ \\ \\ \\ \\____/\\_\\    ____   ___\\ \\ \\___        ___    ___    ___ ___    
 /\\ \\/\\ \\ / __`\\/' _ `\\ \\ \\ \\ \\ \\ '__`\\/\\ \\  /',__\\ /'___\\ \\  _ `\\     /'___\\ / __`\\/' __` __`\\  
 \\ \\ \\_/ /\\ \\_\\ \\\\ \\/\\ \\ \\ \\_\\ \\ \\ \\_\\ \\ \\ \\/\\__, `/\\ \\__/\\ \\ \\ \\ \\ __/\\ \\__//\\ \\_\\ \\\\ \\/\\ \\/\\ \\ 
  \\ \\___/\\ \\____/ \\_\\ \\_\\ \\_____\\ \\____/\\ \\_\\/\\____\\ \\____\\\\ \\_\\ \\_/\\_\\ \\____\\ \\____/ \\_\\ \\_\\ \\_\\
   \\/__/  \\/___/ \\/_/\\/_/\\/_____/\\/___/  \\/_/\\/___/ \\/____/ \\/_/\\/_\\/_/\\/____/\\/___/ \\/_/\\/_/\\/_/

-->
<html lang=\"\">
    <head>
        <meta charset=\"utf-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <meta name=\"description\" content=\"\">
        <meta name=\"keywords\" content=\"\">
        <meta name=\"author\" content=\"{{ app.application.author }}\">
        <meta name=\"application-name\" content=\"vuApplication\">
        <meta name=\"msapplication-TileColor\" content=\"#000000\">
        <meta name=\"theme-color\" content=\"#999999\">
        <meta property=\"og:site_name\" content=\"\">
        <meta property=\"og:url\" content=\"\">
        <meta property=\"og:title\" content=\"\">
        <meta property=\"og:type\" content=\"\">
        <meta property=\"og:image\" content=\"\">
        <meta property=\"og:video\" content=\"\">
        <meta property=\"og:audio\" content=\"\">
        <meta property=\"og:description\" content=\"\">
        <meta property=\"fb:app_id\" content=\"\">
        <meta name=\"twitter:card\" content=\"\">
        <meta name=\"twitter:site\" content=\"\">
        <meta name=\"twitter:title\" content=\"\">
        <meta name=\"twitter:description\" content=\"\">
        <meta name=\"twitter:image\" content=\"\">
        <title>{{ app.application.name }}</title>
        <base href=\"{{ app.enviroment.base }}\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css\">
        <link rel=\"icon\" href=\"assets/img/favicon/favicon.ico\">
        <link rel=\"apple-touch-icon\" href=\"assets/img/favicon/favicon.png\">
        <link rel=\"author\" type=\"text/plain\" href=\"humans.txt\">
        <!--[if lt IE 9]>
          <script src=\"https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js\"></script>
          <script src=\"https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js\"></script>
        <![endif]-->
    </head>
    {{ test }}
    <body>
        <script src=\"//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js\"></script>
        <script src=\"//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js\"></script>
    </body>
</html>";
    }
}
