<?php
$temp = $fileObj;
?>
<article class="file-card flex flex-col justify-between w-full min-h-20 md:min-h-40 file-item p-2 md:p-4 min-h-fit">
  <header class="flex justify-between items-top">
    <span class="text-bold md:text-3xl pl-4 text-ellipsis" dir="ltr"><?= $fileObj->name ?></span>
    <div class="actions whitespace-nowrap" data-file-id="<?= $fileObj->id ?>">
      <button class="delete w-6 md:w-8 h-6 md:h-8"><img src="<?= NLS__PLUGIN_URL . '/public/images/delete.svg' ?>" width="32" height="32" alt=""></button>
      <button class="download w-6 md:w-8 h-6 md:h-8"><img src="<?= NLS__PLUGIN_URL . '/public/images/download.svg' ?>" width="32" height="32" alt=""></button>
    </div>
  </header>
  <footer class="md:2xl pt-3"><?= __('Uploaded At', 'NlsHunterFbf') . ' ' . date('d/m/Y', $fileObj->updateDate) ?></footer>
</article>