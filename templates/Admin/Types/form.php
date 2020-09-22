<?php
/**
 * @method App\View\Helper\Bootstrap4\FormHelper $form;
 */
$colLeft = [
    'title' => [],
    'slug' => [],
    'vocabularies._ids' => ['options' => $vocabularies, 'multiple' => 'checkbox']
];

$this->set(compact('colLeft'));
$this->extend('/Admin/Common/sb_admin_form');
