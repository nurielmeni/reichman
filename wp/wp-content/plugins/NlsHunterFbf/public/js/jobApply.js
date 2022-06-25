var JobApply =
    JobApply ||
    (function ($) {
        "use strict";
        var rtl = false;
        var lang = 'en-US';
        var jobApplyForm = '.search-results-wrapper .job-apply-form-wrapper';
        var jobApplyButton = '.job-apply-form-wrapper button.job-apply-btn';

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

        function showApplyFormOnCard(jobCard) {
            $(jobApplyForm).appendTo($(jobCard));
            showApply();
        }

        function beforeApply() {
            // 1. Hide the apply form
            hideApply();

            // 2. Show loading indication
            $(jobApplyForm).nlsLoader();
        }

        function afterApply() {
            //$.nlsRemoveLoader();
        }

        function applyForJob(event) {
            var jobCard = $(event.target).parents('.job-card');
            var jobCode = $(jobCard).data('job-code');

            var formData = new FormData();
            formData.append('jobCode', jobCode);
            formData.append('action', 'apply_for_job');

            $.ajax({
                url: frontend_ajax.url,
                data: formData,
                beforeSend: beforeApply,
                contentType: false,
                cache: false,
                processData: false,
                method: "POST",
                dataType: "json",
            })
                .done(function (data) {
                    $.nlsRemoveLoader();
                    $(jobApplyForm).after(data.html);
                })
                .fail(function () {
                    $.nlsRemoveLoader();
                    alert("error");
                })
                .always(afterApply);
        }

        function getApply() {
            return jobApplyForm;
        }

        function hideApply() {
            $(jobApplyForm).addClass('hidden');
        }

        function showApply() {
            $(jobApplyForm).removeClass('hidden').addClass('animate-slide-down');
        }

        function registerEventListeners() {
            $(document).on('click', jobApplyButton, applyForJob.bind(this));

            $(document).on('click', 'button.back', function (event) {
                JobSearch.hideJobDetails(event);
                $(this).parents('.submit-response').remove();
            });
        }

        function init() {
            console.log('Apply Job Init');

            rtl = $('html').attr('dir') === 'rtl';
            lang = $('html').attr('lang');

            $('.job-apply-form-wrapper select.sumo').each(function () { initSumoSelect(this); });

            registerEventListeners()
        }

        return {
            init: init,
            getApply: getApply,
            showApplyFormOnCard: showApplyFormOnCard,
            hideApply: hideApply
        }
    })(jQuery);

jQuery(function () {
    JobApply.init();
});