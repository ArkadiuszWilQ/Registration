<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ResourcesRole[]|\Cake\Collection\CollectionInterface $resourcesRoles
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Resources Role'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Resources'), ['controller' => 'Resources', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Resource'), ['controller' => 'Resources', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="resourcesRoles index large-9 medium-8 columns content">
    <h3><?= __('Resources Roles') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('resource_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('role_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resourcesRoles as $resourcesRole): ?>
            <tr>
                <td><?= $this->Number->format($resourcesRole->id) ?></td>
                <td><?= h($resourcesRole->type) ?></td>
                <td><?= $resourcesRole->has('resource') ? $this->Html->link($resourcesRole->resource->id, ['controller' => 'Resources', 'action' => 'view', $resourcesRole->resource->id]) : '' ?></td>
                <td><?= $resourcesRole->has('role') ? $this->Html->link($resourcesRole->role->name, ['controller' => 'Roles', 'action' => 'view', $resourcesRole->role->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $resourcesRole->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $resourcesRole->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $resourcesRole->id], ['confirm' => __('Are you sure you want to delete # {0}?', $resourcesRole->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
