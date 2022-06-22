

(function ($) {
    $.fn.extend({
        nlsLoader: function () {
            $(this).after(
                '<div id="nls-loader-wrapper" class="nls-rounded-10 nls-box-shadow"><div id="nls-loader" class="loader">אנא המתן...</div></div>'
            );
        },

    });

    $.extend({
        nlsRemoveLoader: function () {
            $('#nls-loader-wrapper').remove();
        }
    });
})(jQuery);