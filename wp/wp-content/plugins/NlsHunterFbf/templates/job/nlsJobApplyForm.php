<?php

?>

<div class="job-apply-form-wrapper w-full hidden overflow-hidden origin-top relative">
    <div class="decor my-10 mx-auto h-1 bg-light w-9/12"></div>
    <form class="flex flex-col flex-wrap justify-center items-center md:flex-row">
        <div class="apply-rounded-container md:bg-primary">
            <span class="text-xl text-primary md:text-white mb-5"><?= __('Select CV file', 'NlsHunterFbf') ?></span>
            <?= render('form/nlsSelectField', [
                'options' => [['id' => 1, 'name' => 'Meni']],
                'name' => 'cv-file',
                'class' => 'text-lg rounded-md md:bg-white md:text-primary bg-primary text-white min-w-[229px] md:min-w-0',
            ]) ?>
            <p class="hidden md:block text-xl text-white mt-1 mb-2"><?= __('Or', 'NlsHunterFbf') ?></p>
            <button type="button" class="hidden md:block rounded-md bg-white text-primary text-lg py-1 w-44"><?= __('Add New', 'NlsHunterFbf') ?></button>
        </div>

        <img src="<?= plugins_url('NlsHunterFbf/public/images/down-chevron.svg') ?>" class="md:rotate-270 rtl:md:rotate-90 w-5 md:w-10" alt="">

        <div class="apply-rounded-container bg-white md:bg-dark-gray">
            <span class="text-xl text-primary md:text-white text-center"><?= __('Select other files', 'NlsHunterFbf') ?></span>
            <p class="text-sm md:text-white text-center mb-7 inline md:block"><?= __('(Not Required)', 'NlsHunterFbf') ?></p>
            <?= render('form/nlsSelectField', [
                'options' => [['id' => 1, 'name' => 'Meni']],
                'name' => 'additional-file',
                'class' => 'text-lg rounded-md bg-dark-gray text-white md:bg-white md:text-primary min-w-[229px] md:min-w-0',
            ]) ?>
            <p class="hidden md:block text-xl text-white mt-1 mb-2"><?= __('Or', 'NlsHunterFbf') ?></p>
            <button type="button" class="hidden md:block rounded-md bg-white text-primary text-lg py-1 w-44"><?= __('Add New', 'NlsHunterFbf') ?></button>
        </div>

        <img src="<?= plugins_url('NlsHunterFbf/public/images/down-chevron.svg') ?>" class="md:rotate-270 rtl:md:rotate-90 w-5 md:w-10" alt="">

        <div class="apply-rounded-container bg-white md:bg-light">
            <button type="button" class="job-apply-btn rounded-md bg-light md:bg-white text-primary text-xl text-bold py-2 mt-2 mb-10 w-44 min-w-[229px]"><?= __('Apply CV', 'NlsHunterFbf') ?><span class="inline md:hidden">&nbsp;&nbsp;&gt;&gt;</span></button>

            <div class="flex justify-end md:justify-center items-center w-full">
                <img src="http://localhost:8080/wp-content/plugins/NlsHunterFbf/public/images/apply.png" srcset="http://localhost:8080/wp-content/plugins/NlsHunterFbf/public/images/apply@2x.png 2x,
      http://localhost:8080/wp-content/plugins/NlsHunterFbf/public/images/apply@3x.png 3x" class="max-w-[113px] md:max-w-full">
            </div>
        </div>
    </form>
</div>