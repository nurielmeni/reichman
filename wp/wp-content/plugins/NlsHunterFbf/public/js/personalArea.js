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

        function getBinaryFile(fileId, fileName, mimeType) {
            const oReq = new XMLHttpRequest();
            oReq.open("GET", "/myfile.png", true);
            oReq.responseType = "blob";

            oReq.onload = function (oEvent) {
                const blob = oReq.response;

            };

            oReq.send();
        }

        function openFile(data) {
            console.log('data', data);
            var linkSource = `data:${data.params.mimeType},${data.fileData}` || false;
            var fileName = data.params.fileName || false;
            if (!linkSource || !fileName) return;

            const downloadLink = document.createElement('a');
            document.body.appendChild(downloadLink);

            downloadLink.href = linkSource;
            downloadLink.target = '_self';
            downloadLink.download = fileName;
            downloadLink.click();
            //downloadLink.remove();
        }

        function openFileByteArray(data) {
            console.log('data', data);

            var bytes = new Uint8Array(data.fileData); // pass your byte response to this constructor

            var blob = new Blob([bytes], { type: data.params.mimeType });// change resultByte to bytes

            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = data.params.fileName;
            link.click();
            //downloadLink.remove();
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
                var fileId = $(this).data('fileId');
                var fileName = $(this).data('fileName');
                var mimeType = $(this).data('mimeType');
                fileId && getBinaryFile(fileId, fileName, mimeType);
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