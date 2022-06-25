<?php
include_once NLS__PLUGIN_PATH . '/includes/Hunter/NlsHelper.php';
?>

<div class="hot-job-card flex flex-col justify-between items-center my-3 md:p-4" job-code="<?= NlsHelper::proprtyValue($element, 'JobCode') ?>">
  <div class="flex justify-end w-full"><span class="text-sm md:text-lg"><?= NlsHelper::dateFormat(NlsHelper::proprtyValue($element, 'UpdateDate')) ?></span></div>
  <div class="title text-center min-h-[5em]"><span class="text-center font-bold text-base md:text-3xl line-clamp-2"><?= NlsHelper::proprtyValue($element, 'JobTitle') ?></span></div>
  <div class="details flex flex-col-reverse md:flex-row justify-around w-full items-top min-h-[4em]">
    <span class="text-sm md:text-xl text-center whitespace-wrap"><?= NlsHelper::proprtyValue($element, 'EmployerName') ?></span>
    <span class="text-sm md:text-xl text-center whitespace-nowrap"><?= NlsHelper::proprtyValue($element, 'JobCode') ?></span>
  </div>
  <div class="flex justify-center">
    <button type="button" class="w-120 font-bold text-sm md:text-lg py-1 mt-1 md:py-3 px-5 border-t border-gray-300">
      <?= __('More details', 'NlsHunterFbf') ?>
    </button>
  </div>
</div>