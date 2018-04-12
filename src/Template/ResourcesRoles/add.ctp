<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ResourcesRole $resourcesRole
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Resources Roles'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Resources'), ['controller' => 'Resources', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Resource'), ['controller' => 'Resources', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="resourcesRoles form large-9 medium-8 columns content">
    <?= $this->Form->create($resourcesRole) ?>
    <fieldset>
        <legend><?= __('Add Resources Role') ?></legend>
        <?php
            echo $this->Form->radio('type', ['denny' => 'Denny', 'require' => 'Require', 'one_of_many' => 'One of many']);
            echo $this->Form->select('resource_id', $resourcesOptions);
            echo $this->Form->control('role_id', ['options' => $roles]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
