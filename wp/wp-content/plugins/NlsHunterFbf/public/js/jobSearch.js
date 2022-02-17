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
            var el = '.nls-hunter-search-wrapper .search-advanced';
            if ($(el).hasClass('hidden')) {
                $(el).removeClass('hidden');
                $(el).slideDown(500);
            } else {
                $(el).slideUp(500, function () {
                    $(this).addClass('hidden');
                });
            }

        }

        function clearFields() {
            $('.nls-hunter-search-wrapper input').val('');
            $('.nls-hunter-search-wrapper select.sumo').each(function () {
                $(this)[0].sumo.unSelectAll();
            });
        }

        function search(e) {
            console.log(e);
            var form = $(e.target).parents('form')[0];
            var formData = new FormData(form);
            form.submit();
        }

        function showJobDetails(event) {
            var el = event.target;
            var jobCard = $(el).parents('.job-card');
            var jobCards = '.search-results-wrapper .job-card';
            var jobApplyForm = '.search-results-wrapper .job-apply-form';
            var gridWrapper = '.search-results-wrapper > .grid';
            var detailsClasses = 'details md:col-span-2 lg:col-span-3';

            // Scroll to top of the grid
            $('.search-results-wrapper').get(0).scrollIntoView({behavior: "smooth", block: "start", inline: "center"});

            // Move the job card to the top of the grid (before the form) and Make the card full width
            $(jobApplyForm).prependTo($(gridWrapper));

            // Remove other card details
            $(jobCards).removeClass(detailsClasses);

            // Show the selected card details
            $(jobCard).insertBefore($(jobApplyForm)).addClass(detailsClasses);
            $(jobApplyForm).removeClass('hidden');
        }

        function registerEventListeners() {
            // Toggle advanced search options
            $('.nls-hunter-search-wrapper .search-buttons button.advanced').on('click', toggleAdvanced);

            // Clear fileds
            $('.nls-hunter-search-wrapper .search-buttons button.eraser').on('click', clearFields);

            // Clear fileds
            $('.nls-hunter-search-wrapper button.search').on('click', search);

            // Show job details and submit form
            $(document).on('click', '.job-card .additional-details', showJobDetails);
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