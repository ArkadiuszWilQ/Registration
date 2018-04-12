<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ResourcesRole $resourcesRole
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Resources Role'), ['action' => 'edit', $resourcesRole->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Resources Role'), ['action' => 'delete', $resourcesRole->id], ['confirm' => __('Are you sure you want to delete # {0}?', $resourcesRole->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Resources Roles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Resources Role'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Resources'), ['controller' => 'Resources', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Resource'), ['controller' => 'Resources', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="resourcesRoles view large-9 medium-8 columns content">
    <h3><?= h($resourcesRole->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($resourcesRole->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Resource') ?></th>
            <td><?= $resourcesRole->has('resource') ? $this->Html->link($resourcesRole->resource->id, ['controller' => 'Resources', 'action' => 'view', $resourcesRole->resource->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= $resourcesRole->has('role') ? $this->Html->link($resourcesRole->role->name, ['controller' => 'Roles', 'action' => 'view', $resourcesRole->role->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($resourcesRole->id) ?></td>
        </tr>
    </table>
</div>
