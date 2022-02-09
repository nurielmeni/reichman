<?php

/**
 * @label
 * @name
 * @type
 * @class
 * @validators
 * @prepend
 */
$required =  isset($validators) && strpos($validators, 'required')  !== false;
?>
<div class="nls-field <?= isset($wrapperClass) ? $wrapperClass : '' ?>">
  <?php if ($label) : ?>
    <label class="w-100 flex justify-between"><?= isset($label) ? $label : '' ?><span><? $required ? __('Not required', 'NlsHunterFbf') : '' ?></span></label>
  <?php endif; ?>
  <div class="relative">
    <?= isset($prepend) ? '<img src="' . $prepend . '" width="24" height="24" class="inset-center" />' : '' ?>
    <input type="<?= isset($type) ? $type : 'text' ?>" name="<?= isset($name) ? $name : '' ?>" class="<?= isset($prepend) ? ' pl-11 rtl:pl-0 rtl:pr-11' : '' ?> <?= isset($class) ? $class : '' ?>" validator="<?= isset($validators) ? $validators : '' ?>" aria-invalid="false" aria-required="<?= $required  ? 'true' : 'false' ?>">
  </div>

  <div class="help-block"></div>
</div>