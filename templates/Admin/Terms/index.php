<?php
$trRows[] = 'text-center w-5';
$trRows[] = 'd-none d-sm-none d-md-none d-lg-table-cell d-xl-table-cell';
$trRows[] = 'p-0';

$this->assign('title', $menu->title);
$this->extend('/Admin/Common/sb_admin_index');
?>
<!--table.thead.tr-->
<?php $this->start('thread'); ?>
<th><?= $this->Paginator->sort('id') ?></th>
<th><?= $this->Paginator->sort('title') ?></th>
<th><?= __('Actions') ?></th>
<?php $this->end(); ?>

<!--table.tbody.tr-->
<?php $this->start('tbody'); ?>
<td>{{ $row->id }}</td>
<td class="<?= $trRows[2] ?>">{{ h($row->title) . $this->Html->small($row->slug,['class'=>'d-block']) }}</td>
<td class="actions">
    {{ $this->element('bootstrap4/link/view') }} -
    {{ $this->element('bootstrap4/link/edit') }}
</td>
<?php $this->end(); ?>