<?php

/**
 * @jobs
 */
?>

<section class="search-results-wrapper">
    <div class="title flex justify-start mb-2 py-6 px-4 text-white bg-primary">
        <span><?= count($jobs) ?></span><span><?= __('Jobs', 'NlsHunterFbf') ?></span>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <?php foreach ($jobs as $job) : ?>
            <div class="job-card w-full">
                <?= $job['jobTitle'] ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>