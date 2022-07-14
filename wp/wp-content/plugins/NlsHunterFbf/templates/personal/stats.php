<article class="flex flex-wrap flex-col md:flex-row justify-center py-8 px-5 bg-bg-light mx-4 md:mx-0 gap-4">

    <?php foreach ($statItems as $statItem) : ?>
        <?= render('personal/statItem', ['statItem' => $statItem]) ?>
    <?php endforeach; ?>
</article>