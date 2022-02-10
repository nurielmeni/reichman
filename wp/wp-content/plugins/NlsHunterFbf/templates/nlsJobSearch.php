<section class="nls-hunter-search-wrapper nls-main-row alignwide bg-primary relative">
  <div class="search-buttons absolute right-4 rtl:right-auto rtl:left-4 top-4">

    <button type="button" class="mx-2">
      <img src="<?= plugins_url('NlsHunterFbf/public/images/eraser.svg') ?>" height="30" alt="" class="top">
    </button>
    <button type="button" class="mx-2">
      <img src="<?= plugins_url('NlsHunterFbf/public/images/advanced.svg') ?>" height="30" alt="" class="top">
    </button>
  </div>

  <form name="nls-job-search" action="" class="pt-10 pr-40 pl-6 rtl:pr-6 rtl:pl-40">
    <div class="search-main flex justify-between items-center">
      <?= render('nlsInputField', [
        'label' => null,
        'name' => 'keywords',
        'type' => 'text',
        'wrapperClass' => 'mr-10 rtl:mr-0 ml-10 w-full',
        'class' => 'text-2xl py-3 rounded-xl w-full',
        'validators' => 'required',
        'prepend' => plugins_url('NlsHunterFbf/public/images/search.svg'),
      ]) ?>

      <button type="button" class="btn text-2xl py-3 px-8 rounded-xl"><?= __('Search', 'NlshunterFbf') ?></button>
    </div>
    <div class="search-advanced flex justify-between w-100">
      <?= render('nlsAdvancedSearch', []) ?>
    </div>
    <p class="text-white text-xl pt-6 pb-3"><?= __('You can define each search as an agent in the personal area', 'NlsHunterFbf') ?></p>
  </form>
</section>