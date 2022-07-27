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

        function getPersonalDashboardData(dashboard) {
            getUserData('get_user_cv_files').then(function (res) {
                $(dashboard).find('.cv-files .count').text(res.params.count).removeClass('animate-pulse');
                console.log('cv_files', res);
            })
                .catch(function (res) {
                    console.debug('get_user_cv_files:error', res);
                    $.growl.error('Get userCV files', res);
                });

        }

        function getUserData(action) {
            var data = {
                action: action
            };

            $('.nls-modal header h3').text('');
            $('.nls-modal').data('action', action);

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
                    $('.nls-modal header h3').text(res.params.label);
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
                    $('.nls-modal header h3').text(res.params.label);
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
                    $('.nls-modal header h3').text(res.params.label);
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
                    $('.nls-modal header h3').text(res.params.label);
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
                    $('.nls-modal header h3').text(res.params.label);
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
                    showError('#fileManagerModal footer', res.title, res.message);
                });
        }

        function showError(parentEl, title, message) {
            $(parentEl).find('.title').text(title);
            $(parentEl).find('.message').text(message);
            $(parentEl).find('.error').slideDown();
        }

        function openFile(res) {
            if (res.status !== 'success') {
                showError('#fileManagerModal footer', res.title, res.message);
                return;
            }

            var downloadLink = document.createElement('a');
            document.body.appendChild(downloadLink);

            downloadLink.href = res.fileUrl;
            downloadLink.target = '_self';
            downloadLink.download = res.params.fileName;
            downloadLink.click();
            downloadLink.remove();
        }

        function updateCounter(el, addVal) {
            var stats = $('section.stats ' + el + ' p.count').text();


        }

        function newFile(fileType, fileCardsEl) {
            var fileInput = document.createElement('input');
            document.body.appendChild(fileInput);

            fileInput.type = 'file';
            fileInput.accept = 'doc,docx,pdf,rtf,txt';

            $(fileInput).on('change', function () {
                var formData = new FormData();
                formData.append("file", this.files[0]);
                formData.append("action", "new_file");
                formData.append("type", fileType);
                $.ajax({
                    url: frontend_ajax.url,
                    type: 'POST',
                    data: formData,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,  // tell jQuery not to set contentType
                    cache: false,
                })
                    .done(function (res) {
                        if (res && res.status === 'success') {
                            $(fileCardsEl).append(res.html);
                        } else {
                            showError('#fileManagerModal footer', res.title, res.message);
                        }
                    })
                    .fail(function (res) {
                        console.debug('res', res);
                        showError('#fileManagerModal footer', 'Error', 'Insert File Error');
                    });
            });

            fileInput.click();
            fileInput.remove();
        }

        function showAgent(event) {
            var el = event.target;

            // 1. Show the form and focus first input
            $('section.add-edit-smart-agent').slideDown().find('input').get(0).focus();
        }

        function addEditAgent(event) {
            var el = event.target;
            var formData = $(el).parents('form').serialize();
            formData += '&action=add_edit_hunter';

            $.ajax({
                url: frontend_ajax.url,
                data: formData,
                method: 'post',
                cache: false
            })
                .done(function (res) {
                    console.debug('res', res);
                    if (res.status === 'success') {
                        $('section.smart-agents > article').prepend(res.html);
                    } else {
                        $.growl.error({
                            title: 'Something Went Wrong',
                            message: res
                        })
                    }
                })
                .fail(function (res) {
                    console.debug('res', res);
                    $.growl.error({
                        title: 'Something Went Wrong',
                        message: res
                    })
                });

        }

        function deleteAgent(event) {
            var el = event.target;
            var agentId = $(el).parents('.smart-agent-card').data('agent-id');
            $.ajax({
                url: frontend_ajax.url,
                data: {
                    action: 'delete_hunter',
                    'hunter-id': agentId
                },
                method: 'post',
                cache: false
            })
                .done(function (res) {
                    if (res.status === 'success') {
                        $(el).parents('.smart-agent-card').remove();
                    }
                    console.log('res', res);
                })
                .fail(function (res) {
                    console.debug('res', res);
                });
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
                var fileCardEl = $(this).parents('article.file-card');
                fileId && deleteFile(fileId, fileCardEl);
            });

            /**
             * New file
             */
            $(document).on('click', 'button.new-file', function () {
                var fileType = $(this).data('file-type');
                var fileCardsEl = $(this).parents('section.file-items');

                newFile(fileType, fileCardsEl);
            });

            /**
             * Show add/edit Agent
             */
            $('.smart-agent-card button.new-agent').on('click', showAgent);

            /**
             * Add Edit Agent
             */
            $('form[name="nls-agent-add-edit"] button.search').on('click', addEditAgent);

            /**
             * Delete Agent
             */
            $(document).on('click', 'article.smart-agent-card button.delete', deleteAgent);

            /**
             * Close error
             */
            $(document).on('click', 'button.close-error', function () {
                $(this).parents('.error').slideUp();
            });
        }

        function init() {
            console.log('Personal Area Init');

            rtl = $('html').attr('dir') === 'rtl';
            lang = $('html').attr('lang');

            var dashboard = $('section.personal-dashboard').get(0);
            if (dashboard) {
                getPersonalDashboardData(dashboard);
            }

            registerEventListeners()
        }

        return {
            init: init
        }
    })(jQuery);

jQuery(function () {
    Agent.init();
});