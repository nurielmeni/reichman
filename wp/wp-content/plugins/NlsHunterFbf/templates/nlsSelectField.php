<?php

/**
 * @label
 * @name
 * @class
 * @required
 * @placeHolder
 * @multiple
 * @options
 */
$required =  isset($required) && $required;
?>
<div class="nls-field select <?= isset($wrapperClass) ? $wrapperClass : '' ?>">
  <?php if (isset($label)) : ?>
    <label class="w-100 flex justify-between"><?= $label ?><span><? $required ? __('Not required', 'NlsHunterFbf') : '' ?></span></label>
  <?php endif; ?>
  <div class="relative">
    <select name="<?= isset($name) ? $name : '' ?>" class="sumo <?= isset($class) ? $class : '' ?>" validator="<? isset($required) && $required ? 'required' : '' ?>" aria-invalid="false" aria-required="<?= isset($required) && $required ? 'true' : 'false' ?>" placeholder="<?= isset($placeHolder) ? $placeHolder : '' ?>" <?= isset($multiple) && $multiple ? 'multiple' : '' ?>>
      <?php foreach ($options as $option) : ?>
        <option value="<?= $option['id'] ?>"><?= $option['name'] ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="help-block"></div>
</div>