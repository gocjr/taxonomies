<?php

/**
 * @method App\View\Helper\Bootstrap4\FormHelper $form;
 */
?>

<?= $this->Form->create($row) ?>
<div class="card shadow m-0">
    <div class="card-header btn-group-sm px-3">
        <?= $this->element('Bootstrap4/btn/save') ?>
        <?= $this->element('Bootstrap4/btn/apply') ?>
        <?= $this->element('Bootstrap4/btn/cancel', ['url' => ['action' => 'index']]) ?>
    </div>
    <div class="card-body">
        <?= $this->Form->control('title') ?>
        <?= $this->Form->control('slug') ?>
        <?= $this->Form->control('vocabularies._ids', ['options' => $vocabularies, 'multiple' => 'checkbox', 'inline' => true]) ?>
    </div>
</div>
<?= $this->Form->end() ?>