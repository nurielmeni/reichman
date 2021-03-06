<?php
include_once ABSPATH . 'wp-content/plugins/NlsHunterFbf/includes/Hunter/NlsHelper.php';
/**
 * @jobs
 * @jobDetailsPageUrl
 */
?>

<section class="search-results-wrapper">
    <div class="title flex justify-start mb-2 py-6 px-4 text-2xl text-white bg-primary">
        <span><?= $jobs['totalHits'] ?></span><span class="mx-2"><?= __('Jobs', 'NlsHunterFbf') ?></span>
    </div>
    <?= render('job/nlsJobApplyForm', ['nlsJobApplyUrl' => '#']) ?>
    <ul class="job-list grid grid-cols-1 md:grid-cols-2 md:grid-cols-3 gap-6">
        <?php foreach ($jobs['list'] as $job) : ?>
            <?= render('job/nlsJobCard', [
                'model' => $model,
                'job' => $job,
                'jobDetailsPageUrl' => $jobDetailsPageUrl . '?jobcode=' .  NlsHelper::proprtyValue($job, 'JobCode')
            ]) ?>
        <?php endforeach; ?>
    </ul>
    <div class="footer flex justify-center items-center">
        <?= render('loader', ['id' => 'jobs-loader']) ?>
    </div>
</section>