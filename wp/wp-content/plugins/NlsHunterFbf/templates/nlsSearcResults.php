<?php
include_once ABSPATH . 'wp-content/plugins/NlsHunterFbf/includes/Hunter/NlsHelper.php';
/**
 * @jobs
 * @jobDetailsPageUrl
 */
?>

<section class="search-results-wrapper">
    <div class="title flex justify-start mb-2 py-6 px-4 text-2xl text-white bg-primary">
        <span><?= NlsHelper::proprtyValue($jobs, 'TotalHits', 0) ?></span><span class="mx-2"><?= __('Jobs', 'NlsHunterFbf') ?></span>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?= render('nlsJobApplyForm', ['nlsJobApplyUrl' => '#']) ?>
        <?php foreach (NlsHelper::proprtyValue(NlsHelper::proprtyValue($jobs, 'Results'), 'JobInfo', []) as $job) : ?>
            <?= render('nlsJobCard', [
                'model' => $model,
                'job' => $job,
                'jobDetailsPageUrl' => $jobDetailsPageUrl . '?jobcode=' .  NlsHelper::proprtyValue($job, 'JobCode')
            ]) ?>
        <?php endforeach; ?>
    </div>
</section>