<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resource $resource
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $resource->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $resource->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Resources'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="resources form large-9 medium-8 columns content">
    <?= $this->Form->create($resource) ?>
    <fieldset>
        <legend><?= __('Edit Resource') ?></legend>
        <?php
            echo $this->Form->control('controller');
            echo $this->Form->control('action');
            echo $this->Form->control('roles._ids', ['options' => $roles]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
