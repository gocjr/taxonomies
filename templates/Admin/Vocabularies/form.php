<?php

/**
 * @method App\View\Helper\Bootstrap4\FormHelper $form;
 */

$attrOptions = [
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
?>

<?= $this->Form->create($row) ?>
<div class="card shadow m-0">
    <div class="card-header btn-group-sm px-3">
        <?= $this->element('Bootstrap4/btn/save') ?>
        <?= $this->element('Bootstrap4/btn/apply') ?>
        <?= $this->element('Bootstrap4/btn/cancel', ['url' => ['action' => 'index']]) ?>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-7 col-lg-8 col-xl-9">
                <?= $this->Form->control('title') ?>
                <?= $this->Form->control('slug') ?>
                <?= $this->Form->control('types._ids', ['options' => $types, 'multiple' => 'checkbox-inline']) ?>
            </div>
            <div class="col-12 col-sm-6 col-md-5 col-lg-3 col-xl-3">
                <?= $this->Form->control('attrs.multiple', $attrOptions) ?>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->end() ?>