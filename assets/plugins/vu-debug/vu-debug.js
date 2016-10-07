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

    }

    var vuDebug = new vuDebug();
    vuDebug.countAllMessages('.vu-debug-count');

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