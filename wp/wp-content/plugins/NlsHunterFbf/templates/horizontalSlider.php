<?php
  require_once ABSPATH . 'wp-content/plugins/NlsHunterFbf/renderFunction.php';
  /**
   * @param elements, array of elements
   * @param elementTemplate, template view file for the element
   * 
   **/
?>

<div class="hs-wrapper flex justify-center items-center relative">
  <button type="button" class="nav left absolute top-auto left-3 w-7 h-7 bg-primary rounded-full"><</button>
  <button type="button" class="nav right absolute top-auto right-3 w-7 h-7 bg-primary rounded-full">></button>
  <div class="hs-container flex justify-center items-center">
      <?php foreach($elements as $element) : ?>
        <?= render($elementTemplate, ['element' => $element]) ?>
        <?php endforeach; ?>
  </div>
</div>