
<?= $this->Form->create($formData) ?>
<div class="card shadow m-0">
    <div class="card-header btn-group-sm px-3">
        <?= $this->element('Bootstrap4/btn/add', ['url' => ['action' => 'add']]) ?>
        <?= $this->element('Bootstrap4/btn/deleteAll') ?>
        <div class="d-inline-block col-5">
            <?= $this->element('Bootstrap4/form/search') ?>
        </div>
    </div>
    <table class="table table-striped table-borderless m-0">
        <thead>
            <tr>
                <th scope="col" style="width:20px"><?= $this->Form->checkbox('checkall') ?></th>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col" class="text-center"><?= $this->Paginator->sort('actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $i => $row) : ?>
                <tr>
                    <td><?= $this->Form->checkbox('check.' . $i, ['value' => $row->id, 'class' => 'child']) ?></td>
                    <td><?= $row->id ?></td>
                    <td class="py-0">
                        <?= $row->title ?>
                        <p class="small text-black-50 pb-0 mb-0"><?= $row->slug ?></p>
                    </td>
                    <td class="text-center" id="action">
                        <?= $this->element('Bootstrap4/link/view', ['url' => ['action' => 'view', $row->id]]) ?> -
                        <?= $this->element('Bootstrap4/link/edit', ['url' => ['action' => 'edit', $row->id]]) ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <div class="card-footer">
        <?= $this->element('Bootstrap4/btn/paginator') ?>
    </div>
</div>
<?= $this->Form->end() ?>