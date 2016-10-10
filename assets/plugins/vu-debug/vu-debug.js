$(document).ready(function () {

    function vuDebug(config) {

        this.config = {
            root: $('base').attr('href')
        };
        $.extend(this.config, config);
        this.toggle = function () {
            $('#vu-debug-bar').toggleClass('open');
            if ($('#vu-debug-bar').is('.open')) {
                this.open();
            } else {
                this.close();
            }
            return false;
        };
        this.open = function () {
            $('#vu-debug-bar').addClass('open');
            $('.vu-debug-tab:first-child').addClass('open');
            $('#vu-debug-tabs li:first-child a').addClass('open');
            $('#vu-debug-close').show();
            return false;
        };
        this.close = function () {
            $('#vu-debug-bar').removeClass('open');
            $('.vu-debug-tab').removeClass('open');
            $('#vu-debug-tabs li a').removeClass('open');
            $('#vu-debug-close').hide();
            return false;
        };
        this.openTab = function (element) {
            if (!$('#vu-debug-bar').is('.open')) {
                this.toggle(element);
            }
            $('.vu-debug-tab').scrollTop(0);
            var target = element.attr('href');
            $('#vu-debug-tabs li a').removeClass('open');
            element.addClass('open');
            $('.vu-debug-tab').removeClass('open');
            $(target).addClass('open');
            return false;
        };
        this.toggleCode = function (element) {
            var content;
            if (!element.find('pre').length) {
                content = element.find('.vu-debug-toggle-pre').html();
                element.find('.vu-debug-toggle-pre').html('<pre>' + content + '</pre>');
            } else {
                content = element.find('.vu-debug-toggle-pre pre').html();
                element.find('.vu-debug-toggle-pre').html(content);
            }
            return false;
        };
        this.countAllMessages = function (element) {
            $(element).each(function () {
                $(this).html($($(this).parent().attr('href') + ' table tr').length);
            });
        };
        this.countMessages = function (target) {
            return $(target).length;
        };
        this.highlightJSON = function (element) {
            $(element).each(function () {
                try {
                    json = JSON.stringify(JSON.parse($(this).html()), null, 2);
                } catch (e) {
                    return;
                }
                json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                $(this).html(json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
                    var cls = 'number';
                    if (/^"/.test(match)) {
                        if (/:$/.test(match)) {
                            cls = 'key';
                        } else {
                            cls = 'string';
                        }
                    } else if (/true|false/.test(match)) {
                        cls = 'boolean';
                    } else if (/null/.test(match)) {
                        cls = 'null';
                    }
                    return '<span class="' + cls + '">' + match + '</span>';
                }));
            });
        };
//        this.console = function (element) {
//            element = $(element);
//            //alert(element.html());
//            object = JSON.stringify(JSON.parse(element.html()), null, 2);
//            var html = '<table>';
//            $.each(object, function (i, val) {
//                html += '<tr><td>';
//                html += '<p class="vu-debug-toggle-pre">' + val.data + '<small>' + val.type + '</small></p>';
//                html += '</td><td>' + val.file + ' <span class="vu-debug-badge">' + val.line + '</span>';
//                html += '</td></tr>';
//            });
//            html += '<table>';
//            element.html(html);
//        };
    }

    var vuDebug = new vuDebug();
//    vuDebug.countAllMessages('.vu-debug-count');
//    vuDebug.console('#vu-debug-tab-Console pre');
    vuDebug.highlightJSON('.vu-debug-tab pre');
    $('#vu-debug-header:not(#vu-debug-tabs ul)').on('click', function () {
        return vuDebug.toggle();
    });
    $('#vu-debug-close').on('click', function () {
        return vuDebug.close();
    });
    $('#vu-debug-tabs li a').on('click', function () {
        return vuDebug.openTab($(this));
    });
    $('.vu-debug-tab table tr:has(.vu-debug-toggle-pre)').on('click', function () {
        return vuDebug.toggleCode($(this));
    });
    if (vuDebug.countMessages('#vu-debug-tab-console table tr')) {
        vuDebug.open();
    }

});