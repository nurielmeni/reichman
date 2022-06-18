<?php
require_once NLS__PLUGIN_PATH . '/renderFunction.php';
/**
 * @param elements, array of elements
 * @param elementTemplate, template view file for the element
 * 
 **/
?>

<div class="hs-wrapper  relative w-full alignfull">

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