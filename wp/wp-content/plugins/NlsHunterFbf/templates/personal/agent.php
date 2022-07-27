<?php
require_once NLS__PLUGIN_PATH . 'includes/Hunter/NlsHelper.php';
?>
<article class="smart-agent-card flex flex-col items-center text-center p-4 bg-white min-h-[12rem] m-0" data-agent-id="<?= NlsHelper::proprtyValue($agent, 'Value') ?>">
    <header class="flex justify-end w-full">
        <button type="button" class="delete" title="<?= __('Remove Agent', 'NlsHunterFbf') ?>">
            <img src="<?= NLS__PLUGIN_URL . 'public/images/delete.svg' ?>" alt="" width="32">
        </button>
    </header>
    <h2 class="font-bold line-clamp-3"><?= NlsHelper::proprtyValue($agent, 'Text') ?></h2>
    <footer class="mt-auto">
        <!-- <p><?= __('Created on-', 'NlsHunterFbf') ?><span class="mx-2"><?= NlsHelper::proprtyValue($agent, 'Status') ?></span></p> -->
    </footer>
</article>