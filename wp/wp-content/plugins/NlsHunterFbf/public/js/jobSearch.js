var JobSearch =
    JobSearch ||
    (function ($) {
        "use strict";
        var rtl = false;
        var lang = 'en-US';
        var jobsGrid = 'section.search-results-wrapper > ul.grid';
        var loading = false;

        var jocCardsDetailsBtn = '.job-card button.additional-details',
            jocCardsCancelBtn = '.job-card button.cancel',
            jobSearchForm = '.nls-hunter-search-wrapper form',
            detailsClasses = 'details md:col-span-2 md:col-span-3 md:p-8 animate-expand',
            applyBtn = '.job-card button.apply',
            moreResultsBtn = '.search-results-wrapper .footer button.more-results',
            jobCategory = '.nls-hunter-search-wrapper select[name="job-category[]"]',
            jobCategoryButton = '.nls-hunter-categories-wrapper button.category-card',
            applyEmployer = '.job-card button.apply-employer';

        function toggleAdvanced() {
            var el = '.nls-hunter-search-wrapper .advanced-wrapper';
            if ($(el).hasClass('hidden')) {
                $(el).removeClass('hidden');
                $(el).slideDown(500);
            } else {
                $(el).slideUp(500, function () {
                    $(this).addClass('hidden');
                });
            }
        }

        function search() {
            var form = $(jobSearchForm).submit();
        }

        function searchByCategory(event) {
            var el = event.target;
            var categoryId = $(el).parents('button').attr('category-id');


            clearFields();
            $(jobCategory).val([categoryId]);
            search();
        }

        function showJobDetails(event) {
            var el = event.target;
            var jobCard = $(el).parents('.job-card');
            if ($(jobCard).hasClass('details')) return jobCard;

            $(jobCard).removeClass('animate-expand w-full');
            $(jobCard).find('header span').removeClass('w-1/3');
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
            $(jobCard).find('header span').addClass('w-1/3');
            $(jobCard).addClass('animate-expand w-full');
        }

        function showSpinner() {
            $('.footer .spinner svg').removeClass('hidden');
        }

        function hideSpinner() {
            $('.footer .spinner svg').addClass('hidden');
        }

        function moreResults(page) {
            if (loading) return;
            var page = page || $(jobsGrid).data('page') || 1;

            var data = new FormData(document.querySelector('form[name="nls-job-search"]'));
            data.append('page', page);
            data.append('action', 'results_page');

            $.ajax({
                url: frontend_ajax.url,
                method: "POST",
                //enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                data: data,
                beforeSend: function () {
                    showSpinner();
                    loading = true;
                },
                success: renderMoreResults,
                dataType: 'json',
                complete: function () {
                    loading = false;
                    hideSpinner();

                    // Call this function so the wp will inform the change to the post
                    $(document.body).trigger("post-load");
                }
            });


        }

        function renderMoreResults(htmMoreResults) {
            if (typeof htmMoreResults !== 'object' || !htmMoreResults.hasOwnProperty('results')) return;

            var decodedResults = $("<div />").html(htmMoreResults.results).text();
            $(jobsGrid).append(decodedResults);

            if (htmMoreResults.hasOwnProperty('page'))
                $(jobsGrid).data('page', htmMoreResults.page)

            if (htmMoreResults.count)
                ScrollTo && ScrollTo.setCalls('#jobs-loader .spinner', 1);
            else
                ScrollTo && ScrollTo.remove('#jobs-loader .spinner');

        }

        function clearFields() {
            FormValidator && FormValidator.clearFields(jobSearchForm);
        }

        function registerEventListeners() {
            // Toggle advanced search options
            $('.nls-hunter-search-wrapper .search-buttons button.advanced').on('click', toggleAdvanced);

            // Clear fileds
            $('.nls-hunter-search-wrapper .search-buttons button.eraser').on('click', clearFields);

            // Search
            $('.nls-hunter-search-wrapper button.search').on('click', search);

            // Show job details and submit form
            $(document).on('click', jocCardsDetailsBtn, showJobDetails);

            // Hide job details
            $(document).on('click', jocCardsCancelBtn, hideJobDetails);

            // Load more serach results
            $(document).on('click', moreResultsBtn, moreResults);

            $(document).on('click', applyBtn, showApplyForm);

            $(document).on('click', jobCategoryButton, searchByCategory);

            // Load more serach results
            //$(document).on('click')
        }

        function init() {
            console.log('Job search Init');

            rtl = $('html').attr('dir') === 'rtl';
            lang = $('html').attr('lang');

            registerEventListeners()

            ScrollTo && ScrollTo.add('#jobs-loader .spinner', moreResults, 1);
        }

        return {
            init: init,
            hideJobDetails: hideJobDetails
        }
    })(jQuery);

jQuery(function () {
    JobSearch.init();
});