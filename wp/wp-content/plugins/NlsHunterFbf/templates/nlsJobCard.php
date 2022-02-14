<?php

/**
 * @job
 * 
 */
?>
<div class="job-card flex flex-col justify-between items-center w-full">
  <h2 class="job-title text-2xl text-primary font-bold truncate w-full" title="<?= $job['jobTitle'] ?>">
    <?= $job['jobTitle'] ?>
  </h2>
  <div class="flex justify-between text-xl my-3 w-full">
    <span class="whitespace-nowrap"><?= $job['jobCode'] ?></span>
    <span class="w-full border-x-4 mx-2 px-2 border-primary text-center"><?= $job['employerName'] ?></span>
    <span class="whitespace-nowrap"><?= $job['updateDate'] ?></span>
  </div>
  <div class="text-description text-xl">
    <?= mb_strimwidth(strip_tags(trim($job['description'])), 0, 130, '...') ?>
  </div>
  <a href="<?= $jobDetailsPageUrl ?>" class="text-center text-primary text-xl my-3"><?= __('Additional Details', 'NlsHunterFbf') ?></a>
  <div class="flex justify-start gap-3 w-full mb-4">
    <span class="bg-chip text-primary px-2 rounded-md"><?= $model->getValueById($model->jobRanks(), $job['rank']) ?></span>
    <span class="bg-chip text-primary px-2 rounded-md">מלאה</span>
  </div>

  <?php if (false) : ?>
    <button type="button" class="rounded-md bg-secondary text-white px-8 text-xl font-bold py-1">
      <?= __('Submit in employer site', 'NlsHunterFbf') ?>
    </button>
  <?php else : ?>
    <button type="button" class="rounded-md bg-primary text-white px-8 text-xl font-bold py-1">
      <?= __('Upload CV and submit', 'NlsHunterFbf') ?>
    </button>
  <?php endif; ?>

</div>