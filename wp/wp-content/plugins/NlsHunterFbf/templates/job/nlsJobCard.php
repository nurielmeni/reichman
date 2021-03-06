<?php
include_once NLS__PLUGIN_PATH . '/includes/Hunter/NlsHelper.php';

$jobLink = NlsHelper::getExtendedProperty($job->ExtendedProperties, 'JobLink', false);

/**
 * @job
 * 
 */
?>
<li class="job-card flex flex-col justify-between items-center w-full" data-job-code="<?= NlsHelper::proprtyValue($job, 'JobCode') ?>">
  <div class="flex space-between items-center w-full">
    <h2 class="job-title text-primary font-bold truncate w-full" title="<?= NlsHelper::proprtyValue($job, 'JobTitle') ?>">
      <?= NlsHelper::proprtyValue($job, 'JobTitle') ?>
    </h2>
    <button type="button" class="hidden additional cancel"><img src="<?= plugins_url('NlsHunterFbf/public/images/cancel.svg') ?>" width="30" alt=""></button>
  </div>
  <header class="flex justify-center items-center text-xl my-3 w-full">
    <span class="w-1/3 text-center whitespace-nowrap"><?= NlsHelper::proprtyValue($job, 'JobCode') ?></span>
    <span class="w-1/3 border-x-2 mx-2 px-2 border-primary text-center"><?= NlsHelper::proprtyValue($job, 'EmployerName') ?></span>
    <span class="w-1/3 text-center whitespace-nowrap"><?= NlsHelper::dateFormat(NlsHelper::proprtyValue($job, 'UpdateDate')) ?></span>
  </header>
  <div class="text-description text-xl overflow-hidden no-additional w-full">
    <?= mb_strimwidth(strip_tags(html_entity_decode(NlsHelper::proprtyValue($job, 'Description'))), 0, 130, '...') ?>
  </div>
  <div class="text-description additional text-xl overflow-hidden w-full hidden">
    <?= strip_tags(html_entity_decode(NlsHelper::proprtyValue($job, 'Description'))) ?>
  </div>
  <button type="button" class="additional-details no-additional text-center text-primary text-xl my-3"><?= __('Additional Details', 'NlsHunterFbf') ?></button>
  <div class="flex justify-start gap-3 w-full mb-4">
    <?php if (strlen(NlsHelper::getValueById($model->jobScopes(), NlsHelper::proprtyValue($job, 'JobScope'))) > 0) : ?>
      <span class="bg-chip text-primary px-2 rounded-md"><?= NlsHelper::getValueById($model->jobScopes(), NlsHelper::proprtyValue($job, 'JobScope')) ?></span>
    <?php endif; ?>
    <?php if (strlen(NlsHelper::getValueById($model->jobRanks(), NlsHelper::proprtyValue($job, 'Rank'))) > 0) : ?>
      <span class="bg-chip text-primary px-2 rounded-md"><?= NlsHelper::getValueById($model->jobRanks(), NlsHelper::proprtyValue($job, 'Rank')) ?></span>
    <?php endif; ?>
  </div>

  <footer>
    <?php if ($jobLink) : ?>
      <a href="<?= $jobLink ?>" class="apply-employer rounded-md bg-secondary text-white px-8 text-xl font-bold py-[7px]">
        <?= __('Submit in employer site', 'NlsHunterFbf') ?>
      </a>
    <?php else : ?>
      <button type="button" class="apply rounded-md bg-primary text-white px-8 text-xl font-bold py-1">
        <?= __('Upload CV and submit', 'NlsHunterFbf') ?>
      </button>
    <?php endif; ?>
  </footer>
</li>