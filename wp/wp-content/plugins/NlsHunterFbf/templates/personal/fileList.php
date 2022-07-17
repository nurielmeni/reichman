<section class="file-items <?= $type ?> grid gap-4 md:grid-cols-2">
    <?php foreach ($files as $file) : ?>
        <article class="flex flex-col justify-between w-full min-h-20 md:min-h-40 file-item p-2 md:p-4 min-h-fit">
            <header class="flex justify-between items-top">
                <span class="text-bold md:text-3xl pl-4 text-ellipsis" dir="ltr"><?= $file->name ?></span>
                <div class="actions whitespace-nowrap">
                    <button class="delete w-6 md:w-8 h-6 md:h-8"><img src="<?= NLS__PLUGIN_URL . '/public/images/delete.svg' ?>" width="32" height="32" alt=""></button>
                    <button class="download  w-6 md:w-8 h-6 md:h-8" data-file-id="<?= $file->id ?>" data-mime-type="<?= $file->mimeType ?>" data-file-name="<?= $file->name ?>"><img src="<?= NLS__PLUGIN_URL . '/public/images/download.svg' ?>" width="32" height="32" alt=""></button>
                </div>
            </header>
            <footer class="md:2xl pt-3"><?= __('Uploaded At', 'NlsHunterFbf') . ' ' . date('d/m/Y', $file->updateDate) ?></footer>
        </article>
    <?php endforeach; ?>
    <article class="flex flex-col justify-center items-center w-full h-20 md:h-40 file-item p-4">
        <button type="button" class="new-file text-6xl md:text-[10rem] leading-none">+</button>
    </article>
</section>