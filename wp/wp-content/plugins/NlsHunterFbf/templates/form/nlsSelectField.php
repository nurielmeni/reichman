<?php

/**
 * @wrapperClass
 * @label
 * @labelClass
 * @name
 * @class
 * @required
 * @placeHolder
 * @multiple
 * @value
 * @options
 * @clearAllButton
 */
$id = isset($name) ? str_replace('[]', '', $name) . '--0' : false;
$required =  isset($required) && $required;
$value = isset($value) && is_array($value) ? $value : [];
?>
<div class="nls-field select <?= isset($wrapperClass) ? $wrapperClass : '' ?>">
  <?php if (isset($label)) : ?>
    <label <?= $id ? 'for="' . $id . '"' : '' ?> class="w-full flex justify-between <?= isset($labelClass) ? $labelClass : '' ?>"><?= $label ?><?= !$required ? ('<span>' . __('Not required', 'NlsHunter') . '</span>') : '' ?></label>
  <?php endif; ?>
  <div class="relative flex md:justify-start items-center w-full">
    <select <?= $id ? 'for="' . $id . '"' : '' ?> name="<?= isset($name) ? $name : '' ?><?= isset($multiple) && $multiple ? '[]' : '' ?>" class="sumo <?= isset($class) ? $class : '' ?>" validator="<?= $required ? 'required' : '' ?>" aria-invalid="false" aria-required="<?= isset($required) && $required ? 'true' : 'false' ?>" placeholder="<?= isset($placeHolder) ? $placeHolder : '' ?>" <?= isset($multiple) && $multiple ? 'multiple' : '' ?> validator="<?= isset($validators) && is_array($validators) ? implode(' ', $validators) : '' ?>" aria-invalid="false" aria-required="<?= $required  ? 'true' : 'false' ?>">
      <?php if (!$multiple && isset($placeHolder)) : ?>
        <option selected value=""><?= $placeHolder ?></option>
      <?php endif; ?>
      <?php foreach ($options as $option) : ?>
        <option value="<?= $option['id'] ?>" <?= in_array($option['id'], $value) ? 'selected' : '' ?>><?= $option['name'] ?></option>
      <?php endforeach; ?>
    </select>
    <?php if (isset($clearAllButton) && $clearAllButton) : ?>
      <button type="button" class="clear <?= isset($clearAllButtonClass) ? $clearAllButtonClass : '' ?>">Claer</button>
    <?php endif; ?>
  </div>

  <div class="help-block text-small text-red-400 min-h-[21px]"></div>
</div>