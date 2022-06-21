<?php

/**
 * @model
 * @searchParams keywords, categoryId, regionValue, employmentType, jobScope, jobLocation, employerId, updateDate
 */

?>

<!-- Professional Fields -->
<?= render('form/nlsSelectField', [
    'options' => $model->categories(),
    'placeHolder' => __('Job Area', 'NlsHunterFbf'),
    'name' => 'job-category',
    'class' => 'rounded-xl border-none py-2 text-xl',
    'value' => key_exists('category', $searchParams) ? $searchParams['category'] : [],
    'multiple' => true
]) ?>

<!-- Job Scope -->
<?= render('form/nlsSelectField', [
    'options' => $model->jobScopes(),
    'placeHolder' => __('Job Scope', 'NlsHunterFbf'),
    'name' => 'job-scope',
    'class' => 'rounded-xl border-none py-2 text-xl',
    'value' => key_exists('scope', $searchParams) ? $searchParams['scope'] : '',
    'multiple' => true
]) ?>

<!-- Audiance -->
<?= render('form/nlsSelectField', [
    'options' => $model->jobRanks(),
    'placeHolder' => __('Job Rank', 'NlsHunterFbf'),
    'name' => 'job-rank',
    'class' => 'rounded-xl border-none py-2 text-xl',
    'value' => key_exists('rank', $searchParams) ? $searchParams['rank'] : '',
    'multiple' => true
]) ?>

<!-- Last Update -->
<?= render('form/nlsInputField', [
    'label' => null,
    'placeHolder' => __('Last Date', 'NlsHunterFbf'),
    'name' => 'last-update',
    'type' => 'text',
    'wrapperClass' => 'date relative',
    'class' => 'py-2 rounded-xl px-2 w-auto lg:w-40',
    'value' => key_exists('lastUpdate', $searchParams) ? $searchParams['lastUpdate'] : '',
    'append' => plugins_url('NlsHunterFbf/public/images/crate-down.svg'),
    'iconSize' => 11
]) ?>

<!-- Employment Form -->
<?= render('form/nlsSelectField', [
    'options' => $model->employmentForm(),
    'placeHolder' => __('Employment Form', 'NlsHunterFbf'),
    'name' => 'employment-form',
    'class' => 'rounded-xl border-none py-2 text-xl',
    'multiple' => true
]) ?>

<!-- Employer Type -->
<?= render('form/nlsSelectField', [
    'options' => $model->jobScopes(),
    'placeHolder' => __('Employer Type', 'NlsHunterFbf'),
    'name' => 'employer-type',
    'class' => 'rounded-xl border-none py-2 text-xl',
    'multiple' => true
]) ?>