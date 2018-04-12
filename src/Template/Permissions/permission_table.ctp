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

    <?php foreach($ret as $resource): ?>
    <tr>
        <td><?= $this->Html->link(__($resource['controller'] . DS . $resource['action']), ['controller' =>'Permissions', 'action' => 'editResources', $resource['id']]) ?></td>
            <?php for($i = 0; $i < count($allRolesName); $i++): ?>
                <?php if(array_key_exists($i, $resource['roles'])): ?>

                    <?php if($resource['roles'][$i]['type'] == 'one_of_many'): ?>
                    <td><img src="/img/permissions/oneOfMany.jpg"/></td>
                    <?php endif; ?>

                    <?php if($resource['roles'][$i]['type'] == 'require') : ?>
                    <td><img src="/img/permissions/require.jpg"/></td>
                    <?php endif; ?>

                    <?php if($resource['roles'][$i]['type'] == 'denny') : ?>
                    <td><img src="/img/permissions/denny.jpg"/></td>
                    <?php endif; ?>

                <?php else : ?>
                    <td></td>
                <?php endif; ?>
            <?php endfor; ?>
    <?php endforeach; ?>
    </tr>
    </tbody>
</table>

<br>

<table>
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






