<?php

/**
 * @wrapperClass
 * @label
 * @name
 * @placeHolder
 * @type
 * @class
 * @validators
 * @prepend
 * @append
 * @iconSize
 * @autofocus
 * @direction (ltr/rtl)
 */
$id = isset($name) ? str_replace('[]', '', $name) . '--0' : false;
$value = isset($value) ? $value : '';
$required =  isset($validators) && is_array($validators) && in_array('required', $validators);
?>
<div class="nls-field input <?= isset($wrapperClass) ? $wrapperClass : '' ?>">
  <?php if (isset($label)) : ?>
    <label <?= $id ? 'for="' . $id . '"' : '' ?> class="w-100 flex justify-between <?= isset($labelClass) ? $labelClass : '' ?>"><?= $label ?></label>
  <?php endif; ?>
  <div class="relative">
    <?= isset($prepend) ? '<img src="' . $prepend . '" width="' . (isset($iconSize) ? $iconSize : 24) . '" height="' . (isset($iconSize) ? $iconSize : 24) . '" class="prepend inset-center" aria-hidden="true" focusable="false" />' : '' ?>
    <input <?= $id ? 'id="' . $id . '"' : '' ?> type="<?= isset($type) ? $type : 'text' ?>" name="<?= isset($name) ? $name : '' ?>" value="<?= isset($value) ? $value : '' ?>" placeholder="<?= isset($placeHolder) ? $placeHolder : '' ?>" class="border-2 <?= isset($prepend) ? ' pl-11 rtl:pl-0 rtl:pr-11' : '' ?> <?= isset($class) ? $class : '' ?>" validator="<?= isset($validators) && is_array($validators) ? implode(' ', $validators) : '' ?>" aria-invalid="false" aria-required="<?= $required  ? 'true' : 'false' ?>" <?= isset($autofocus) &&  $autofocus ? 'autofocus' : '' ?> <?= isset($direction) ? 'dir="' . $direction . '"' : '' ?>>
    <?= isset($append) ? '<img src="' . $append . '" width="' . (isset($iconSize) ? $iconSize : 24) . '" height="' . (isset($iconSize) ? $iconSize : 24) . '" class="append inset-center" aria-hidden="true" focusable="false" />' : '' ?>
  </div>

  <div class="help-block text-small text-red-400 min-h-[21px]"></div>
</div>