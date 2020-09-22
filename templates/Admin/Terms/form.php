<?php

/**
 * @method App\View\Helper\Bootstrap4\FormHelper $form;
 */
$colLeft = [
    'title' => [],
    'slug' => [],
    'taxonomies._ids' => ['options' => $taxonomies, 'multiple' => 'checkbox-inline']
];

$this->set(compact('colLeft'));
$this->extend('/Admin/Common/sb_admin_form');
