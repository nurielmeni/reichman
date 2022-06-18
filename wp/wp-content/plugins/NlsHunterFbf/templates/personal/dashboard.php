<section class="flex flex-col justify-center items-center">
    <div class="double-doted-border border-light mb-8">
        <div class="flex py-4 px-4 md:px-12 bg-light ">
            <div class="text-center cv">
                <p class="text-2xl md:text-6xl"><?= $data['cv'] ?></p>
                <p class="md:text-2xl md:font-bold mt-2"><?= __('My CV Files', 'NlsHunterFbf') ?></p>
            </div>
            <div class="text-center hunted-jobs mx-8 px-8 border-x-2 border-secondary">
                <p class="text-2xl md:text-6xl"><?= $data['hunted-jobs'] ?></p>
                <p class="md:text-2xl md:font-bold mt-2"><?= __('Jobs for me', 'NlsHunterFbf') ?></p>
            </div>
            <div class="text-center applied-jobs">
                <p class="text-2xl md:text-6xl"><?= $data['applied-jobs'] ?></p>
                <p class="md:text-2xl md:font-bold mt-2"><?= __('Applied jobs', 'NlsHunterFbf') ?></p>
            </div>
        </div>
    </div>
    <a href="<?= $personalPageUrl ?>" class="btn all-jobs text-2xl py-3 px-8 rounded-xl">
        <?= __('To personal erae', 'NlsHunterFbf') ?>
    </a>
</section>