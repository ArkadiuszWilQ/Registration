<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resource[]|\Cake\Collection\CollectionInterface $resources
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Resources Role'), ['controller' => 'Resources-Roles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('New Resource'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Resources Role'), ['controller' => 'Resources-Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="resources index large-9 medium-8 columns content">
    <h3><?= __('Resources') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('controller') ?></th>
                <th scope="col"><?= $this->Paginator->sort('action') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resources as $resource): ?>
            <tr>
                <td><?= $this->Number->format($resource->id) ?></td>
                <td><?= h($resource->controller) ?></td>
                <td><?= h($resource->action) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $resource->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $resource->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $resource->id], ['confirm' => __('Are you sure you want to delete # {0}?', $resource->id)]) ?>
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
