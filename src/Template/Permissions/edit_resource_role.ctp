<?= $this->Form->create(null, [
'url' => ['controller' => 'Permissions', 'action' => 'edit_resource_role', $resourceId, $roleId],
'type' => 'post'
]) ?>

<br>
<fieldset>
    <legend><?= __('Select Resource Role') ?></legend>
        <?php
            echo $this->Form->radio(
                'type',
                [
                    ['value' => 'null', 'text' => 'Usuń połączenie zasobu z rolą'],
                    ['value' => 'denny', 'text' => 'Denny'],
                    ['value' => 'one_of_many', 'text' => 'One of many'],
                    ['value' => 'require', 'text' => 'Require']
                ],
                [
                    'empty' => false,
                    'required' => true,
                    'default' => $selectedType
                ]
            );
        ?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>