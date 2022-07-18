<section class="file-items <?= $type ?> grid gap-4 md:grid-cols-2">
    <?php foreach ($files as $fileObj) : ?>
        <?= render('personal/fileItem', ['fileObj' => $fileObj]) ?>
    <?php endforeach; ?>
    <article class="flex flex-col justify-center items-center w-full h-20 md:h-40 file-item p-4">
        <button type="button" class="new-file text-6xl md:text-[10rem] leading-none" data-file-type="<?= $type ?>">+</button>
    </article>
</section>