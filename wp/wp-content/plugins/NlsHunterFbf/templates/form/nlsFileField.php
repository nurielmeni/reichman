<?php

/**
 * @wrapperClass
 * @label
 * @name
 * @buttonText
 * @accept
 * @textClass
 * @buttonClass
 * @validators
 * @mode text/button
 * @direction (ltr/rtl)
 */
$mode = isset($mode) ? $mode : null;
$value = isset($value) ? $value : '';
$required =  isset($validators) && is_array($validators) && in_array('required', $validators) !== false;
?>
<div class="nls-field file <?= isset($wrapperClass) ? $wrapperClass : '' ?>">
  <input type="file" name="<?= isset($name) ? $name : '' ?>" accept="<?= isset($accept) ? $accept : '' ?>" class="hidden" validator="<?= is_array($validators) ? implode(' ', $validators) : '' ?>">
  <label class="w-100 flex justify-between <?= $mode === 'text' ? 'invisible' : '' ?>  <?= isset($labelClass) ? $labelClass : '' ?>"><?= isset($label) ? $label : '' ?></label>

  <div class="flex file-picker items-center <?= isset($pickerClass) ? $pickerClass : '' ?>">
    <?php if ($mode !== 'text') : ?>
      <input type="text" readonly tabindex="-1" name="sel-<?= isset($name) ? $name : '' ?>" value="<?= isset($value) ? $value : '' ?>" class="truncate outline-none	<?= isset($textClass) ? $textClass : '' ?>" validator="<?= is_array($validators) ? implode(' ', $validators) : '' ?>" aria-invalid="false" aria-required="<?= $required  ? 'true' : 'false' ?>" <?= isset($direction) ? 'dir="' . $direction . '"' : '' ?>>
    <?php endif; ?>
    <button type="button" class="<?= isset($buttonClass) ? $buttonClass : '' ?>"><?= isset($buttonText) ? $buttonText : '' ?></button>
    <?php if ($mode == 'text' && isset($iconSrc)) : ?>
      <img src="<?= $iconSrc ?>" class="select-indication mr-2 <?= isset($iconClass) ? $iconClass : '' ?>"></img>
    <?php endif; ?>
  </div>

  <div class="help-block text-small text-red-400"></div>
</div>