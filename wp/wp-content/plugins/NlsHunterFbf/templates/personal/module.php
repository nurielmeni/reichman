<?php
require_once NLS__PLUGIN_PATH . '/renderFunction.php';
?>

<section class="details">
    <header class="flex flex-col justify-center items-center font-bold">
        <span class="md:text-4xl md:pb-2"><?= __('My Personal Area', 'NlsHunterFbf') ?></span>
        <div class="underline-decor"></div>
    </header>

    <?= render('personal/details', []); ?>
</section>

<section class="stats my-12">
    <?= render('personal/stats', [
        'statItems' => $statItems
    ]); ?>
</section>

<section class="smart-agents alignfull">
    <header class="flex flex-col justify-center items-center font-bold">
        <span class="md:text-4xl md:pb-2"><?= __('My Smart Agents', 'NlsHunterFbf') ?></span>
        <div class="underline-decor"></div>
    </header>

    <?= render('personal/agents', [
        'model' => $model,
        'agents' => $agents
    ]); ?>
</section>

<section class="add-edit-smart-agent hidden px-4 md:px-0">
    <?= render('personal/addEditAgent', [
        'model' => $model,
        'searchParams' => $searchParams
    ]); ?>

</section>