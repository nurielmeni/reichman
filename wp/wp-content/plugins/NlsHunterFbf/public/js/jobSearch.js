var JobSearch =
    JobSearch ||
    (function ($) {
        "use strict";
        var rtl = false;
        var lang = 'en-US';

        var jobCards = '.search-results-wrapper .job-card',
            jocCardsDetailsBtn = '.job-card button.additional-details',
            jocCardsCancelBtn = '.job-card button.cancel',
            //jobApplyForm = '.search-results-wrapper .job-apply-form-wrapper',
            detailsClasses = 'details md:col-span-2 lg:col-span-3 md:p-8 animate-expand',
            applyBtn = '.job-card button.apply',
            moreResultsBtn = '.search-results-wrapper .footer button.more-results',
            applyEmployer = '.job-card button.apply-employer';

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

            // To keep the format
            var textVal = $('.nls-hunter-search-wrapper input[name="last-update"]').val();
            var dateVal = $('.nls-hunter-search-wrapper input[name="last-update"]').datepicker('getDate');
            if (dateVal) {
                $('.nls-hunter-search-wrapper input[name="last-update"]').css('color', 'transparent').val(dateVal.toISOString());
            }

            form.submit();

            // To keep the format
            if (dateVal) {
                $('.nls-hunter-search-wrapper input[name="last-update"]').css('color', 'inherit').val(textVal);
            }
        }

        function showJobDetails(event) {
            var el = event.target;
            var jobCard = $(el).parents('.job-card');
            if ($(jobCard).hasClass('details')) return jobCard;

            $(jobCard).removeClass('animate-expand w-full');
            $(jobCard).find('span').removeClass('w-1/3');
            $(jobCard).find('.additional').removeClass('hidden');
            $(jobCard).find('.no-additional').addClass('hidden');
            $(jobCard).get(0).scrollIntoView({ behavior: "smooth" });
            $(jobCard).addClass(detailsClasses);
            return jobCard;
        }

        function showApplyForm(event) {
            if (!JobApply) return;

            var jobCard = showJobDetails(event);
            $(event.target).addClass('hidden');

            JobApply.showApplyFormOnCard(jobCard);
        }

        function hideJobDetails(event) {
            var el = event.target;
            var jobCard = $(el).parents('.job-card');

            JobApply && JobApply.hideApply();
            $(jobCard).find('.additional').addClass('hidden');
            $(jobCard).find('.no-additional').removeClass('hidden');
            $(jobCard).find('button.apply').removeClass('hidden');
            $(jobCard).removeClass(detailsClasses);
            $(jobCard).get(0).scrollIntoView({ behavior: "smooth", block: "center" });
            $(jobCard).find('span').addClass('w-1/3');
            $(jobCard).addClass('animate-expand w-full');
        }

        function moreResults(event) {
            var button = event.target;
            var currentPage = $(button).data('page') || 0;

            $(button).find('svg').removeClass('hidden');

            $.ajax({
                url: frontend_ajax.url,
                data: {
                    action: 'results_page',
                    page: currentPage,
                },
                success: renderMoreResults,
                dataType: 'html'
            });

            // Call this function so the wp will inform the change to the post
            $(document.body).trigger("post-load");

        }

        function renderMoreResults(htmMoreResults) {
            console.log('more', htmMoreResults);
        }

        function datePickersInit() {
            $('.nls-hunter-search-wrapper input[name="last-update"]').datepicker({
                dateFormat: 'd/m/yy',
                regional: 'he'
            });

            // if (lang === 'he-IL') {
            //     $('.nls-hunter-search-wrapper input[name="last-update"]').datepicker(
            //         $.datepicker.regional["he"]
            //     );
            // }

            var d = new Date($('.nls-hunter-search-wrapper input[name="last-update"]').val());
            if (!isNaN(d.valueOf())) {
                $('.nls-hunter-search-wrapper input[name="last-update"]').datepicker('setDate', d)
            }

        }

        function registerEventListeners() {
            // Toggle advanced search options
            $('.nls-hunter-search-wrapper .search-buttons button.advanced').on('click', toggleAdvanced);

            // Clear fileds
            $('.nls-hunter-search-wrapper .search-buttons button.eraser').on('click', clearFields);

            // Clear fileds
            $('.nls-hunter-search-wrapper button.search').on('click', search);

            // Show job details and submit form
            $(document).on('click', jocCardsDetailsBtn, showJobDetails);

            // Hide job details
            $(document).on('click', jocCardsCancelBtn, hideJobDetails);

            // Load more serach results
            $(document).on('click', moreResultsBtn, moreResults);

            $(document).on('click', applyBtn, showApplyForm);

            // Load more serach results
            //$(document).on('click')

            // Date picker colors
            //$('.nls-hunter-search-wrapper input[name="last-update"]').on('change', datePickersColor);
        }

        function init() {
            console.log('Job search Init');

            rtl = $('html').attr('dir') === 'rtl';
            lang = $('html').attr('lang');

            $('.nls-hunter-search-wrapper select.sumo').each(function () { initSumoSelect(this); });

            datePickersInit();

            registerEventListeners()
        }

        return {
            init: init
        }
    })(jQuery);

jQuery(function () {
    JobSearch.init();
});