<?php

/**
 * @method App\View\Helper\Bootstrap4\FormHelper $form;
 */

$colLeft = [
    'title' => [],
    'slug' => [],
    'types._ids' => ['options' => $types, 'multiple' => 'checkbox-inline', 'inline' => true]
];
$colRight = [
    'attrs.multiple' => [
        'size' => 9,
        'label' => 'Exibir lista',
        'default' => 'false',
        'options' => [
            'Select' => [
                'Único',
                'true' => 'Multiplos'
            ],
            'Checkbox' => [
                'checkbox' => 'Vertical',
                'checkbox-inline' => 'Horizontal'
            ],
            'Radio' => [
                'radio' => 'Vertical',
                'radio-inline' => 'Horizontal'
            ]

        ]
    ]
];

$this->set(compact('colLeft','colRight'));
$this->extend('/Admin/Common/sb_admin_form');
