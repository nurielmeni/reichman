<?php

/**
 * @jobs
 * @jobDetailsPageUrl
 */
?>

<section class="search-results-wrapper">
    <div class="title flex justify-start mb-2 py-6 px-4 text-white bg-primary">
        <span><?= count($jobs) ?></span><span><?= __('Jobs', 'NlsHunterFbf') ?></span>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($jobs as $job) : ?>
            <?= render('nlsJobCard', [
                'model' => $model,
                'job' => $job,
                'jobDetailsPageUrl' => $jobDetailsPageUrl . $job['jobCode']
            ]) ?>
        <?php endforeach; ?>
    </div>
</section>