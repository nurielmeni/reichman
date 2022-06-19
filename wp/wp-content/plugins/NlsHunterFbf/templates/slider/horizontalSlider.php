<?php
require_once NLS__PLUGIN_PATH . '/renderFunction.php';
/**
 * @param elements, array of elements
 * @param elementTemplate, template view file for the element
 * 
 **/
?>
<section class="">
  <div class="grid md:grid-rows-1 md:grid-cols-4">
    <div class="hidden md:flex  justify-end items-end">
    </div>
    <div class="flex flex-col justify-center items-center col-span-2 text-center font-bold">
      <span class="md:text-4xl md:pb-2"><?= __('Jobs we thought will intrest you', 'NlsHunterFbf') ?></span>
      <div class="underline-decor"></div>
    </div>

    <div class="hidden md:flex justify-end  items-center -mb-1">
      <img src="<?= plugins_url('NlsHunterFbf/public/images') ?>/hotjobs.png" srcset="<?= plugins_url('NlsHunterFbf/public/images') ?>/hotjobs@2x.png 2x,
     <?= plugins_url('NlsHunterFbf/public/images') ?>/hotjobs@3x.png 3x" class="">
    </div>
  </div>

  <div class="hs-wrapper  relative w-full alignfull bg-sliderbg py-12">
    <div class="hs-buttons">
      <button type="button" class="nav opacity-80 left absolute top-1/2 transform -translate-y-1/2 left-3 w-10 h-10 z-20 bg-sliderbg rounded-full">
        <img src="<?= plugins_url('NlsHunterFbf/public/images/left-chevron.svg') ?>" alt="" class="p-2">
      </button>
      <button type="button" class="nav opacity-80 right absolute top-1/2 transform -translate-y-1/2 right-3 w-10 h-10 z-20 bg-sliderbg rounded-full">
        <img src="<?= plugins_url('NlsHunterFbf/public/images/right-chevron.svg') ?>" alt="" class="p-2">
      </button>
    </div>
    <div class="hs-container overflow-hidden w-full" dir="ltr">
      <?php foreach ($elements as $element) : ?>
        <?= render($elementTemplate, ['element' => $element]) ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>