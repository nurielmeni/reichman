<section class="nls-hunter-search-wrapper nls-main-row alignwide bg-primary relative">
  <div class="search-buttons absolute right-4 rtl:right-auto rtl:left-4 top-4">

    <button type="button" class="mx-2">
        <img src="<?= plugins_url('NlsHunterFbf/public/images/eraser.svg') ?>" height="30" alt="" class="top">
    </button>
    <button type="button" class="mx-2">
        <img src="<?= plugins_url('NlsHunterFbf/public/images/advanced.svg') ?>" height="30" alt="" class="top">
    </button>
  </div>
  
  <form name="nls-job-search" action="">
    <div class="search-main flex justify-between w-100">
      <?= render('nlsInputField', [
         'label' => null,
         'name' => 'keywords',
         'type' => 'text',
         'class' => 'text-2xl py-3 rounded-xl',
         'validators' => 'required',
         'prepend' =>plugins_url('NlsHunterFbf/public/images/search.svg'),
      ]) ?>
    </div>
    <div class="search-advanced flex justify-between w-100"></div>
  </form>
</section>