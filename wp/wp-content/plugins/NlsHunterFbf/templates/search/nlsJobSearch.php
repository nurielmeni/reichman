<?php

/**
 * @model
 * @searchParams keywords, categoryId, regionValue, employmentType, jobScope, jobLocation, employerId, updateDate
 * @searcResultsPageUrl
 */
?>

<section class="nls-hunter-search-wrapper nls-main-row bg-primary relative my-10">
  <div class="search-buttons absolute right-4 rtl:right-auto rtl:left-4 top-4">

    <button type="button" class="mx-2 eraser">
      <img src="<?= plugins_url('NlsHunterFbf/public/images/eraser.svg') ?>" height="30" alt="" class="" aria-hidden="true" focusable="false">
    </button>
    <button type="button" class="mx-2 advanced">
      <img src="<?= plugins_url('NlsHunterFbf/public/images/advanced.svg') ?>" height="30" alt="" class="" aria-hidden="true" focusable="false">
    </button>
  </div>

  <form name="nls-job-search" action="<?= $searcResultsPageUrl ?>" class="pt-20 md:pt-10 px-6">
    <div class="search-main flex justify-between md:pr-32 md:rtl:pr-0 md:rtl:pl-32 items-top">
      <?= render('form/nlsInputField', [
        'label' => null,
        'name' => 'keywords',
        'type' => 'text',
        'wrapperClass' => 'md:mr-10 rtl:mr-0 md:rtl:ml-10 w-full',
        'class' => 'text-2xl py-3 rounded-xl w-full',
        'validators' => 'required',
        'value' => key_exists('keywords', $searchParams) ? $searchParams['keywords'] : '',
        'prepend' => plugins_url('NlsHunterFbf/public/images/search.svg'),
      ]) ?>

      <button type="button" class="btn search hidden md:block text-2xl py-3 px-8 rounded-xl border-2 border-secondary"><?= __('Search', 'NlsHunterFbf') ?></button>
    </div>
    <div class="advanced-wrapper mt-5 h-16">
      <div class="search-advanced flex justify-start gap-4">
        <?= render('search/nlsAdvancedSearch', [
          'model' => $model,
          'searchParams' => $searchParams
        ]) ?>
      </div>
    </div>

    <div class="flex justify-center w-full md:hidden mt-6">
      <button type="button" class="btn search text-2xl py-3 w-full rounded-xl"><?= __('Search', 'NlshunterFbf') ?></button>
    </div>
    <p class="text-white text-xl pt-6 pb-3"><?= __('You can define each search as an agent in the personal area', 'NlsHunterFbf') ?></p>
  </form>
</section>