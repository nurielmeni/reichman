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
        </div>
    </div>
</div>