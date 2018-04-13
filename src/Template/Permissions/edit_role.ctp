<h2> <?php echo ("Nazwa roli: ". $role['name']) ?> </h2>

<br>
<br>
<br>

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