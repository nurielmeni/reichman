<?php

/**
 * @model
 * @searchParams keywords, categoryId, regionValue, employmentType, jobScope, jobLocation, employerId, updateDate
 * @searcResultsPageUrl
 */
?>

<article class="nls-hunter-agent text-primary">
  <p><?= __('My Smart Agent:', 'NlsHunterFbf') ?></p>

  <form name="nls-agent-add-edit">
    <?= render('form/nlsInputField', [
      'label' => null,
      'name' => 'keywords',
      'type' => 'text',
      'placeHolder' => __('Search by name/Job details/Company', 'NlsHunterFbf'),
      'wrapperClass' => 'md:mr-10 rtl:mr-0 md:rtl:ml-10 w-full',
      'class' => 'py-2 md:rounded-xl w-full',
      'validators' => 'required',
      'value' => key_exists('keywords', $searchParams) ? $searchParams['keywords'] : '',
      'prepend' => plugins_url('NlsHunterFbf/public/images/search.svg'),
    ]) ?>

    <div class="search-advanced flex justify-start gap-4 w-full mt-5 <?= wp_is_mobile() ? 'overflow-auto' : '' ?>">
      <?= render('form/nlsInputField', [
        'name' => 'hunter-name',
        'type' => 'text',
        'placeHolder' => __('Agent Name', 'NlsHunterFbf'),
        'wrapperClass' => 'mt-px ',
        'class' => 'py-2 border-none rounded-xl',
        'validators' => 'required',
        'value' => key_exists('agent-name', $searchParams) ? $searchParams['agent-name'] : '',
      ]) ?>

      <?= render('search/nlsAdvancedSearch', [
        'model' => $model,
        'searchParams' => $searchParams
      ]) ?>
    </div>


    <div class="flex justify-start items-center gap-4 mt-24">
      <?= render('form/nlsCheckbox', [
        'label' => __('Happy to get Email updates', 'NlsHunterFbf'),
        'name' => 'approve-email',
        'class' => 'scale-150',
        'value' => key_exists('approve-email', $searchParams) ? $searchParams['approve-email'] : false,
      ]) ?>

      <?= render('form/nlsSelectField', [
        'wrapperClass' => 'max-w-[140px]',
        'name' => 'email-frequency',
        'options' => $model->emailFrequency(),
        'class' => 'rounded-xl border-none py-2 text-xl',
        'value' => key_exists('scope', $searchParams) ? $searchParams['scope'] : '',
      ]) ?>
    </div>

    <div class="flex justify-center md:justify-start mt-6 relative z-50">
      <button type="button" data-hunter-id="" class="btn search text-2xl px-16 py-2 rounded-xl"><?= __('Save smart agent', 'NlsHunterFbf') ?></button>
    </div>
  </form>
</article>