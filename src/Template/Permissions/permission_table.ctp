<table border="2">
    <thead>
    <tr>
        <th>#</th>

        <?php foreach($allRolesName as $roleName): ?>
        <th><strong><?php  echo $roleName?></strong><br>
            <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>

    <?php foreach($ret as $resource): ?>
    <tr>
        <td>
            <?php
              echo($resource['controller']. DS .$resource['action'])
            ?>
        </td>
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
                    <td>X</td>
                <?php endif; ?>
            <?php endfor; ?>
    <?php endforeach; ?>
    </tr>



    <!--<tr>-->
    <!--<td>users/add</td>-->
    <!--<td><img src="/img/permissions/oneOfMany.jpg"/></td>-->
    <!--<td></td>-->
    <!--<td></td>-->
    <!--<td></td>-->
    <!--<td></td>-->
    <!--<td></td>-->
    <!--<td></td>-->
    <!--</tr>-->
    <!--<tbody>-->
    <!--<tr>-->
    <!--<td>users/edit</td>-->
    <!--<td></td>-->
    <!--<td><img src="/img/permissions/oneOfMany.jpg"/></td>-->
    <!--<td></td>-->
    <!--<td></td>-->
    <!--<td></td>-->
    <!--<td></td>-->
    <!--<td></td>-->
    <!--</tr>-->
    <!--<tr>-->
    <!--<td>users/delete</td>-->
    <!--<td></td>-->
    <!--<td></td>-->
    <!--<td><img src="/img/permissions/require.jpg"/></td>-->
    <!--<td></td>-->
    <!--<td></td>-->
    <!--<td></td>-->
    <!--<td></td>-->
    <!--</tr>-->
    <!--<tr>-->
    <!--<td>roles/add</td>-->
    <!--<td></td>-->
    <!--<td></td>-->
    <!--<td></td>-->
    <!--<td></td>-->
    <!--<td><img src="/img/permissions/oneOfMany.jpg"/></td>-->
    <!--<td></td>-->
    <!--<td></td>-->
    <!--</tr>-->
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






