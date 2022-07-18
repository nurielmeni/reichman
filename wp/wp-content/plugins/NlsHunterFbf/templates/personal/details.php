<?php

?>

<article class="relative md:p-bl-e-11 bg-white px-6 py-2 my-5 mx-8 md:mx-0">

    <dl class="flex flex-col md:flex-row justify-between align-center mx-4">
        <div class="flex flex-col items-start py-2 border-b border-border md:border-b-0">
            <dt><?= __('Full Name', 'NlsHunterFbf') ?></dt>
            <dd class="md:text-xl"><strong><?= $user->fullName ?></strong></dd>
        </div>

        <div class="flex flex-col items-start py-2 border-b border-border md:border-b-0">
            <dt><?= __('Mail', 'NlsHunterFbf') ?></dt>
            <dd class="md:text-xl"><strong><?= $user->email ?></strong></dd>
        </div>

        <div class="flex flex-col items-start py-2 border-b border-border md:border-b-0">
            <dt><?= __('Phone', 'NlsHunterFbf') ?></dt>
            <dd class="md:text-xl"><strong><?= $user->phone ?></strong></dd>
        </div>

        <div class="flex flex-col items-start py-2">
            <dt><?= __('Id Number', 'NlsHunterFbf') ?></dt>
            <dd class="md:text-xl"><strong><?= $user->userName ?></strong></dd>
        </div>
    </dl>
    <button type="button" class="absolute -top-6 md:top-2.5 left-2.5">
        <img src="<?= NLS__PLUGIN_URL . '/public/images/edit.svg' ?>" alt="" width="20">
    </button>
</article>