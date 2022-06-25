var Agent =
    Agent ||
    (function ($) {
        "use strict";
        var rtl = false;
        var lang = 'en-US';

        function registerEventListeners() {
        }

        function init() {
            console.log('Agent Init');

            rtl = $('html').attr('dir') === 'rtl';
            lang = $('html').attr('lang');

            registerEventListeners()
        }

        return {
            init: init
        }
    })(jQuery);

jQuery(function () {
    Agent.init();
});