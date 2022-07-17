var Agent =
    Agent ||
    (function ($) {
        "use strict";
        var rtl = false;
        var lang = 'en-US';
        var personalAreaActions = {
            'cv-list': myCvFiles,
            'file-list': myFileList,
            'applied-jobs': myAppliedJobs,
            'agent-jobs': myAgentJobs,
            'my-area-jobs': myAreaJobs
        }

        function getUserData(action) {
            var data = {
                action: action
            };

            console.log('getUserData: ', action);
            return new Promise((resolve, reject) => {
                $.post(
                    frontend_ajax.url,
                    data,
                    function (res) {
                        resolve(res);
                    })
                    .fail(function (res) {
                        reject(false);
                    })
                    .always(function () {
                        $.nlsRemoveLoader();
                    });
            });
        }

        function myCvFiles() {
            getUserData('get_user_cv_files')
                .then(function (res) {
                    $('.nls-modal article.body').html(res.html);
                    console.log('cv_files', res);
                })
                .catch(function (res) {
                    console.debug('get_user_cv_files:error', res);
                });
        }

        function myFileList() {
            getUserData('get_user_file_list')
                .then(function (res) {
                    $('.nls-modal article.body').html(res.html);
                    console.log('file_list', res);
                })
                .catch(function (res) {
                    console.debug('get_user_file_list:error', res);
                });
        }

        function myAppliedJobs() {
            getUserData('get_user_applied_jobs')
                .then(function (res) {
                    $('.nls-modal article.body').html(res.html);
                    console.log('applied_jobs', res);
                })
                .catch(function (res) {
                    console.debug('get_user_applied_jobs:error', res);
                });
        }

        function myAgentJobs() {
            getUserData('get_user_agent_jobs')
                .then(function (res) {
                    $('.nls-modal article.body').html(res.html);
                    console.log('agent_jobs', res);
                })
                .catch(function (res) {
                    console.debug('get_user_agent_jobs:error', res);
                });
        }

        function myAreaJobs() {
            getUserData('get_user_area_jobs')
                .then(function (res) {
                    $('.nls-modal article.body').html(res.html);
                    console.log('area_jobs', res);
                })
                .catch(function (res) {
                    console.debug('get_user_area_jobs:error', res);
                });
        }

        function downloadFile(fileId) {
            $.ajax({
                url: frontend_ajax.url,
                data: {
                    action: 'download_file',
                    fileId: fileId,
                },
                method: 'post',
                cache: false
            })
                .done(openFile)
                .fail(function (res) {
                    console.debug('res', res);
                });
        }

        function deleteFile(fileId, fileCard) {
            $.ajax({
                url: frontend_ajax.url,
                data: {
                    action: 'delete_file',
                    fileId: fileId,
                },
                method: 'post',
                cache: false
            })
                .done(function (res) {
                    $(fileCard).hide('slow', function () { fileCard.remove(); });
                })
                .fail(function (res) {
                    console.debug('res', res);
                });
        }

        function openFile(res) {
            if (!res.fileUrl) return;

            const downloadLink = document.createElement('a');
            document.body.appendChild(downloadLink);

            downloadLink.href = res.fileUrl;
            downloadLink.target = '_self';
            downloadLink.download = res.params.fileName;
            downloadLink.click();
            downloadLink.remove();
        }

        function registerEventListeners() {
            /**
             * User Actions
             */
            $('button.modal-action').on('click', function () {
                // Shoe modal
                $.nlsRemoveLoader();
                var modal = '#' + $(this).data('modal-toggle');
                $(modal)
                    .toggleClass('hidden')
                    .attr('aria-hidden', $(modal).attr('aria-hidden') === "true" ? "false" : "true")
                    .find('article.body')
                    .nlsLoader();

                // Run the action function
                var action = $(this).data('action');
                console.log('Action', action);
                if (!action || typeof personalAreaActions[action] !== 'function') return;

                // Call the action function
                personalAreaActions[action]();
            });

            /**
             * Download file
             */
            $(document).on('click', 'button.download', function () {
                var fileId = $(this).parent().data('fileId');
                fileId && downloadFile(fileId);
            });

            /**
             * Delete file
             */
            $(document).on('click', 'button.delete', function () {
                var fileId = $(this).parent().data('fileId');
                var fileCard = $(this).parents('article.file-card');
                fileId && deleteFile(fileId, fileCard);
            });

        }

        function init() {
            console.log('Personal Area Init');

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