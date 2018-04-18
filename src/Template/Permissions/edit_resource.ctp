<h2> <?php echo ("Nazwa kontrolera: " . $resource['controller'] . "/" . $resource['action']) ?> </h2>

<?= $this->Form->create(null, [
'url' => ['controller' => 'Permissions', 'action' => 'edit_resource', $id],
'type' => 'post'
]) ?>

<br>
<fieldset>
    <legend><?= __('Select Resource Role') ?></legend>
        <?php
            if(isset($type) == false) {
            echo $this->Form->radio(
                'type',
                [
                    ['value' => 'denny', 'text' => 'Denny'],
                    ['value' => 'one_of_many', 'text' => 'One of many'],
                    ['value' => 'require', 'text' => 'Require']
                ],
                [
                    'empty' => false,
                    'required' => true
                ]);
            } else {
                    echo $this->Form->hidden('type', ['value' => $type]);
                    echo $this->Form->radio(
                    'type_show',
                [
                    ['value' => 'denny', 'text' => 'Denny'],
                    ['value' => 'one_of_many', 'text' => 'One of many'],
                    ['value' => 'require', 'text' => 'Require']
                ],
                [
                    'value' => $type,
                    'disabled' => true,
                ]
            );

            echo $this->Form->multiCheckbox('roles_ids', $roles, [
            'default' => $selectedOptionsIds
            ]);
            }
        ?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>