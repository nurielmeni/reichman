<?php
require_once ABSPATH . 'wp-content/plugins/NlsHunterFbf/renderFunction.php';
/**
 * @param elements, array of elements
 * @param elementTemplate, template view file for the element
 * 
 **/
?>

<div class="hs-wrapper flex justify-center  items-center relative w-full pt-6 pb-8">
  <div class="hidden md:block">
    <button type="button" class="nav opacity-50 left  absolute top-auto pb-1 text-2xl left-3 w-10 h-10 font-bold bg-sliderbg rounded-full">
      < </button>
        <button type="button" class="nav opacity-50 right hidden md:block absolute top-auto pb-1 pl-1 text-2xl right-3 w-10 h-10 font-bold bg-sliderbg rounded-full">>
        </button>
  </div>
  <div class="hs-container overflow-hidden flex justify-start items-center w-full">
    <?php foreach ($elements as $element) : ?>
      <?= render($elementTemplate, ['element' => $element]) ?>
    <?php endforeach; ?>
  </div>
</div>