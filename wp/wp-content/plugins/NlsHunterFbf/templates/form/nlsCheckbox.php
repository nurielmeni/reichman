<?php

/**
 * @wrapperClass
 * @label
 * @name
 * @class
 * @validators
 * @autofocus
 */
$id = isset($name) ? str_replace('[]', '', $name) . '--0' : false;
$value = isset($value) ? $value : false;
$required =  isset($validators) && is_array($validators) && in_array('required', $validators);
$label = isset($label) ? $label : '';
?>

<div class="nls-field input <?= isset($wrapperClass) ? $wrapperClass : '' ?>">
  <input <?= $id ? 'id="' . $id . '"' : '' ?> type="checkbox" name="<?= isset($name) ? $name : '' ?>" <?= isset($value) && $value ? 'checked' : '' ?> class="<?= isset($class) ? $class : '' ?>" aria-invalid="false" <?= isset($autofocus) &&  $autofocus ? 'autofocus' : '' ?> validator="<?= isset($validators) && is_array($validators) ? implode(' ', $validators) : '' ?>">
  <label <?= $id ? 'for="' . $id . '"' : '' ?> class="<?= isset($labelClass) ? $labelClass : '' ?>"><?= $label ?></label>
  <div class="help-block text-small text-red-400 min-h-[21px]"></div>
</div>