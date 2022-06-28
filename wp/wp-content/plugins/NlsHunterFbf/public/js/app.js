"use strict";
(function ($) {
    var rtl = false;
    var lang = 'en-US';

    var container = '.hs-container';

    function initSumoSelect(selectBoxItem) {
        var name = $(selectBoxItem).attr('name') || '';
        var placeholder = $(selectBoxItem).attr('placeholder') || '';

        $('select.sumo[name="' + name + '"]').SumoSelect({
            placeholder: placeholder,
            search: true,
            csvDispCount: 2,
            okCancelInMulti: true,
            isClickAwayOk: true,
            searchText: (rtl ? 'חפש ' : 'Search ') + placeholder,
            locale: rtl ? ['בחר', 'בטל', 'בחר הכל', 'בטל הכל'] : ['OK', 'Cancel', 'Select All', 'Clear ALL'],
            captionFormat: rtl ? '{0} נבחרו' : '{0} Selected',
            captionFormatAllSelected: rtl ? '{0} כולם נבחרו!' : '{0} all selected!',
        });
    }

    $(function () {
        console.log('App Init');

        rtl = $('html').attr('dir') === 'rtl';
        lang = $('html').attr('lang');

        // Init the image slider
        $(container).slick({
            dots: false,
            infinite: true,
            autoplay: true,
            slidesToScroll: 1,
            nextArrow: 'button.nav.left',
            prevArrow: 'button.nav.right',
            centerMode: true,
            mobileFirst: true,
            centerPadding: '1rem',
            slidesToShow: 1,
            responsive: [
                {
                    breakpoint: 1400,
                    settings: {
                        slidesToShow: 4
                    }
                },
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2
                    }
                }]
        });

        $('.nls-field select.sumo').each(function () { initSumoSelect(this); });
    });
})(jQuery);