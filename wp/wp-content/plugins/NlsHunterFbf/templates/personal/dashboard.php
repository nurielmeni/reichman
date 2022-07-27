<section class="personal-dashboard flex flex-col justify-center items-center my-8">
    <div class="double-doted-border border-light min-w-[94%] md:min-w-[70%]">
        <div class="flex justify-between py-4 bg-sliderbg ">
            <div class="cv-files text-center w-1/3 cv">
                <p class="count animate-pulse text-2xl md:text-6xl"><?= $data['cv'] ?></p>
                <p class="label md:text-2xl md:font-bold mt-2"><?= __('My CV Files', 'NlsHunterFbf') ?></p>
            </div>
            <div class="my-area-jobs text-center w-1/3 hunted-jobs border-x-2 border-secondary">
                <p class="count animate-pulse text-2xl md:text-6xl"><?= $data['hunted-jobs'] ?></p>
                <p class="label md:text-2xl md:font-bold mt-2"><?= __('Jobs for me', 'NlsHunterFbf') ?></p>
            </div>
            <div class="applied-jobs text-center w-1/3 applied-jobs">
                <p class="count animate-pulse text-2xl md:text-6xl"><?= $data['applied-jobs'] ?></p>
                <p class="label md:text-2xl md:font-bold mt-2"><?= __('Applied jobs', 'NlsHunterFbf') ?></p>
            </div>
        </div>
    </div>
    <a href="<?= $personalPageUrl ?>" class="btn all-jobs relative z-20">
        <?= __('To personal erae', 'NlsHunterFbf') ?>
    </a>
</section>