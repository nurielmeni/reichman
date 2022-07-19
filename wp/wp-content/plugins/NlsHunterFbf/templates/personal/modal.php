<!-- File Manager modal -->
<div id="<?= $modalId ?>" tabindex="-1" aria-hidden="true" class="nls-modal flex bg-overlay hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full justify-center items-center">
    <div class="relative p-4 w-11/12 md:w-4/5 h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative shadow bg-white">
            <!-- Modal header -->
            <header class="flex justify-between items-center p-4 bg-primary">
                <h3 class="text-xl font-semibold text-white">
                    <span class="file-counter"></span>
                    <span class="title"></span>
                </h3>
                <button type="button" class="modal-action text-white bg-transparent hover:bg-gray-400 rounded-full text-sm p-2 ml-auto inline-flex items-center border" data-modal-toggle="<?= $modalId ?>">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </header>
            <!-- Modal body -->
            <article class="body p-6 space-y-6">

            </article>
            <footer>
                <div class="error hidden bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                            </svg></div>
                        <div class="mx-2">
                            <p class="title font-bold">Our privacy policy has changed</p>
                            <p class="message text-sm">Make sure you know how these changes affect you.</p>
                        </div>

                        <button type="button" class="close-error px-4 py-3 mr-auto">
                            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title><?= __('Close', 'NlsHunterFbf') ?></title>
                                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>