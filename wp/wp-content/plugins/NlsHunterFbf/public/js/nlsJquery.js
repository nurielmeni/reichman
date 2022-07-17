

(function ($) {
    $.fn.extend({
        nlsLoader: function () {
            $(this).html(
                '<div id="nls-loader-wrapper" class="nls-rounded-10 nls-box-shadow"><div id="nls-loader" class="loader">אנא המתן...</div></div>'
            );
        },

    });

    $.extend({
        nlsRemoveLoader: function () {
            $('#nls-loader-wrapper').remove();
        },
        removeCookie: function (name) {
            document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }
    });
})(jQuery);