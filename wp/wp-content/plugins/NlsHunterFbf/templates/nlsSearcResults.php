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
        <div class="job-apply-form-wrapper w-full hidden">
            <div class="decor my-10 mx-auto h-1 bg-light w-9/12"></div>
            <form class="flex flex-col flex-wrap justify-center items-center md:flex-row">
                <?= render('nlsJobApplyForm', ['nlsJobApplyUrl' => '#']) ?>
            </form>
        </div>
        <?php foreach (NlsHelper::proprtyValue(NlsHelper::proprtyValue($jobs, 'Results'), 'JobInfo', []) as $job) : ?>
            <?= render('nlsJobCard', [
                'model' => $model,
                'job' => $job,
                'jobDetailsPageUrl' => $jobDetailsPageUrl . '?jobcode=' .  NlsHelper::proprtyValue($job, 'JobCode')
            ]) ?>
        <?php endforeach; ?>
    </div>
</section>