<table border="2">
    <thead>
    <tr>
        <th>#</th>
        <?php foreach($rolesName as $key => $value): ?>
        <th><?= $this->Html->link(__($value), ['controller' =>'Permissions', 'action' => 'editRole',  $key]) ?></th>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach($table as $resource): ?>
    <tr>
        <td><?= $this->Html->link($resource['name'], ['controller' =>'Permissions', 'action' => 'editResource', $resource['resource_id']]) ?></td>
        <?php foreach($resource['roles'] as $roleData): ?>
        <?php if(is_null($roleData['type'])): ?>
        <td><?= $this->Html->link(__("not set"), ['controller' =>'Permissions', 'action' => 'edit_resource_role', $resource['resource_id'], $roleData['role_id']]) ?></td>
        <?php else : ?>
        <?php if($roleData['type'] == 'one_of_many'): ?>
        <td><?= $this->Html->image('/img/permissions/oneOfMany.jpg',['url' => ['controller' => 'Permissions', 'action' => 'edit_resource_role', $resource['resource_id'], $roleData['role_id']]]) ?></td>
        <?php elseif($roleData['type'] == 'require') : ?>
        <td><?= $this->Html->image('/img/permissions/require.jpg',['url' => ['controller' => 'Permissions', 'action' => 'edit_resource_role', $resource['resource_id'], $roleData['role_id']]]) ?></td>
        <?php elseif($roleData['type'] == 'denny') : ?>
        <td><?= $this->Html->image('/img/permissions/denny.jpg',['url' => ['controller' => 'Permissions', 'action' => 'edit_resource_role', $resource['resource_id'], $roleData['role_id']]]) ?></td>
        <?php endif; ?>
        <?php endif; ?>
        <?php endforeach; ?>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<br>

<table border="0">
    <tbody>
    <tr>
        <td><img src="/img/permissions/oneOfMany.jpg"/> - musi zawierać jedną z ról</td>
    </tr>
    <tr>
        <td><img src="/img/permissions/require.jpg"/> - musi zawierać konkretną rolę</td>
    </tr>
    <tr>
        <td><img src="/img/permissions/denny.jpg"/> - nie może zawierać roli</td>
    </tr>
    </tbody>
</table>