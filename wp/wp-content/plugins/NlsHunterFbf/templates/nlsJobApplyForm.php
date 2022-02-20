<?php

?>


<div class="apply-rounded-container bg-primary">
    <span class="text-xl text-white"><?= __('Select CV file', 'NlsHunterFbf') ?></span>
</div>
<img src="<?= plugins_url('NlsHunterFbf/public/images/left-chevron.svg') ?>" class="rotate-270 md:rotate-0" width="40" alt="">
<div class="apply-rounded-container bg-dark-gray">
    <div class="flex flex-col items-center">
        <span class="text-xl text-white"><?= __('Select other files', 'NlsHunterFbf') ?></span>
        <span class="text-sm text-white"><?= __('(Not Required)', 'NlsHunterFbf') ?></span>
    </div>
    <?= render('nlsSelectField', [
        'options' => [['id' => 1, 'name' => 'Meni']],
        'name' => 'cv-file'
    ]) ?>

    <button>Add New</button>

</div>
<img src="<?= plugins_url('NlsHunterFbf/public/images/left-chevron.svg') ?>" class="rotate-270 md:rotate-0" width="40" alt="">
<div class="apply-rounded-container bg-light">

</div>