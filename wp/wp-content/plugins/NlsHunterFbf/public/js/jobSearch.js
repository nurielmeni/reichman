var JobSearch =
    JobSearch ||
    (function ($) {
        "use strict";
        var rtl = false;
        var lang = 'en-US';

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

        function toggleAdvanced() {
            $('.nls-hunter-search-wrapper .search-advanced').toggleClass('hidden');
        }

        function clearFields() {
            $('.nls-hunter-search-wrapper input').val('');
            $('.nls-hunter-search-wrapper select.sumo').each(function () {
                $(this)[0].sumo.unSelectAll();
            });
        }

        function search(e) {
            console.log(e);
            var formData = new FormData($(e.target).parents('form')[0]);


        }

        function registerEventListeners() {
            // Toggle advanced search options
            $('.nls-hunter-search-wrapper .search-buttons button.advanced').on('click', toggleAdvanced);

            // Clear fileds
            $('.nls-hunter-search-wrapper .search-buttons button.eraser').on('click', clearFields);

            // Clear fileds
            $('.nls-hunter-search-wrapper button.search').on('click', search);
        }

        function init() {
            console.log('Job search Init');

            rtl = $('html').attr('dir') === 'rtl';
            lang = $('html').attr('lang');

            $('.nls-hunter-search-wrapper select.sumo').each(function () { initSumoSelect(this); });

            $('.nls-hunter-search-wrapper input[name="last-update"]').datepicker({
                dateFormat: 'M d, yy'
            });
            // if (lang === 'he-IL') {
            //     $('.nls-hunter-search-wrapper input[name="last-update"]').datepicker(
            //         $.datepicker.regional["he"]
            //     );
            // } else {
            // }

            registerEventListeners()
        }

        return {
            init: init
        }
    })(jQuery);

jQuery(document).ready(function () {
    JobSearch.init();
});