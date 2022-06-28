<?php

?>

<div class="job-apply-form-wrapper w-full hidden overflow-hidden origin-top relative">
    <div class="decor my-10 mx-auto h-1 bg-light w-9/12"></div>
    <form class="flex flex-col flex-wrap justify-center items-center lg:flex-row">
        <div class="apply-rounded-container lg:bg-primary">
            <span class="text-xl text-primary lg:text-white mb-5"><?= __('Select CV file', 'NlsHunterFbf') ?></span>
            <?= render('form/nlsSelectField', [
                'options' => [['id' => 1, 'name' => 'Meni']],
                'name' => 'cv-file',
                'class' => 'text-lg rounded-md lg:bg-white lg:text-primary bg-primary text-white min-w-[229px] lg:min-w-0',
            ]) ?>
            <p class="hidden lg:block text-xl text-white mt-1 mb-2"><?= __('Or', 'NlsHunterFbf') ?></p>
            <button type="button" class="hidden lg:block rounded-md bg-white text-primary text-lg py-1 w-44"><?= __('Add New', 'NlsHunterFbf') ?></button>
        </div>

        <img src="<?= plugins_url('NlsHunterFbf/public/images/down-chevron.svg') ?>" class="lg:rotate-270 rtl:lg:rotate-90 w-5 lg:w-10" alt="">

        <div class="apply-rounded-container bg-white lg:bg-dark-gray">
            <span class="text-xl text-primary lg:text-white text-center"><?= __('Select other files', 'NlsHunterFbf') ?></span>
            <p class="text-sm lg:text-white text-center mb-7 inline lg:block"><?= __('(Not Required)', 'NlsHunterFbf') ?></p>
            <?= render('form/nlsSelectField', [
                'options' => [['id' => 1, 'name' => 'Meni']],
                'name' => 'additional-file',
                'class' => 'text-lg rounded-md bg-dark-gray text-white lg:bg-white lg:text-primary min-w-[229px] lg:min-w-0',
            ]) ?>
            <p class="hidden lg:block text-xl text-white mt-1 mb-2"><?= __('Or', 'NlsHunterFbf') ?></p>
            <button type="button" class="hidden lg:block rounded-md bg-white text-primary text-lg py-1 w-44"><?= __('Add New', 'NlsHunterFbf') ?></button>
        </div>

        <img src="<?= plugins_url('NlsHunterFbf/public/images/down-chevron.svg') ?>" class="lg:rotate-270 rtl:lg:rotate-90 w-5 lg:w-10" alt="">

        <div class="apply-rounded-container bg-white lg:bg-light">
            <button type="button" class="job-apply-btn rounded-md bg-light lg:bg-white text-primary text-xl text-bold py-2 mt-2 mb-10 w-44 min-w-[229px]"><?= __('Apply CV', 'NlsHunterFbf') ?><span class="inline lg:hidden">&nbsp;&nbsp;&gt;&gt;</span></button>

            <div class="flex justify-end lg:justify-center items-center w-full">
                <img src="http://localhost:8080/wp-content/plugins/NlsHunterFbf/public/images/apply.png" srcset="http://localhost:8080/wp-content/plugins/NlsHunterFbf/public/images/apply@2x.png 2x,
      http://localhost:8080/wp-content/plugins/NlsHunterFbf/public/images/apply@3x.png 3x" class="max-w-[113px] lg:max-w-full">
            </div>
        </div>
    </form>
</div>