<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Resource;
use App\Model\Entity\Role;
use Cake\ORM\TableRegistry;

class PermissionsController extends AppController
{


    public function index()
    {

        return $this->redirect(['controller' => 'Permissions', 'action' => 'permissionTable']);
    }

    public function permissionTable()
    {
        $resourcesTable = TableRegistry::get('Resources');
        $resourcesList = $resourcesTable
            ->find()
            ->toArray();

        /** @var Resource $resourcesRole */
        foreach($resourcesList as $resourcesRole) {
            $controller = ucfirst(strtolower($resourcesRole->controller));
            $action = strtolower($resourcesRole->action);

            $controllerAndActionField[] = $controller . DS . $action;
        }


        $rolesTable = TableRegistry::get('Roles');
        $rolesList = $rolesTable
            ->find()
            ->toArray();

        //wszystkie nazwy ról jakie zostały utworzone
        $allRolesName = [];
        /** @var Role $role */
        foreach($rolesList as $role) {
            $allRolesName[] = $role->name;
        };

        $resourcesTable = TableRegistry::get('Resources');
        $resourcesList = $resourcesTable
            ->find()
            ->contain(['Roles'])
            ->toArray();


        /** @var Resource $resourcesList */
        foreach($resourcesList as $dataForTable) {
            $key = "$dataForTable->controller/$dataForTable->action";
            $ret[$key] = [
                'id' => $dataForTable->id,
                'controller' => $dataForTable->controller,
                'action' => $dataForTable->action,
                'roles' => [],
            ];


            /** @var Role $role */
            foreach($dataForTable->roles as $role) {

                $ret[$key]['roles'][array_search($role['name'], $allRolesName)] = [
                    'id' => $role['id'],
                    'name' => $role['name'],
                    'type' => $role->_joinData['type']
                ];
            };
        };


        foreach($rolesList as $singleRole) {
            $rolesName[$singleRole['id']] = $singleRole['name'];
        }

        $this->set(compact('allRolesName'));
        $this->set(compact('controllerAndActionField'));
        $this->set(compact('ret'));
        $this->set(compact('rolesName'));
    }

    public function editRole($id = null)
    {
        $roleTable = TableRegistry::get('Roles');
        $role = $roleTable
            ->find()
            ->contain(['Resources'])
            ->where(['id' => $id])
            ->first();

        if(is_null($role)) {
            $this->Flash->error('Wprowadziłeś nieistniejące ID roli');

            return $this->redirect(['controller' => 'Permissions', 'action' => 'permissionTable']);
        }

        if($this->request->is('post')) {
            pr($this->request->getData());
            $type = $this->request->getData('type');

            $resources = TableRegistry::get('Resources')
                ->find('list', [
                    'keyField' => 'id',
                    'valueField' => function(Resource $resource) {
                        return "$resource->controller/$resource->action";
                    }
                ])
                ->toArray();

            $selectedOptions = TableRegistry::get('ResourcesRoles')
                ->find()
                ->contain('resources')
                ->where(['ResourcesRoles.role_id' => $id, 'ResourcesRoles.type' => $type])
                ->toArray();

            $selectedOptionsIds = array_column(array_column($selectedOptions, 'Resources'), 'id');
            $resourcesIdsToSave = $this->request->getData('resources_ids');


            if(is_array($resourcesIdsToSave)) {
                $resourceRolesTable = TableRegistry::get('ResourcesRoles');

                $data = [];
                foreach($resourcesIdsToSave as $value) {
                    $data[] = ['type' => $type, 'resource_id' => $value, 'role_id' => $id];
                }

                $entities = $resourceRolesTable->newEntities($data);

                $resourceRolesTable->deleteAll(['role_id' => $id, 'type' => $type]);
                $resourceRolesTable->saveMany($entities);
            }

            $this->set(compact('type', 'resources', 'selectedOptionsIds'));
        }

        $this->set(compact('role', 'id'));
    }

    public function editResource($id = null)
    {

        $rolesTable = TableRegistry::get('Roles');
        $rolesList = $rolesTable
            ->find()
            ->toArray();

        //wszystkie nazwy ról jakie zostały utworzone
        $allRolesName = [];
        /** @var Role $role */
        foreach($rolesList as $role) {
            $allRolesName[] = $role->name;
        };

        $resourcesTable = TableRegistry::get('Resources');
        $resourcesList = $resourcesTable
            ->find()
            ->contain(['Roles'])
            ->innerJoin(['ResourcesRoles' => 'resources_roles'], ['Resources.id = ResourcesRoles.resource_id'])
            ->innerJoin(['Roles' => 'roles'], ['ResourcesRoles.role_id = Roles.id'])
            ->where(['Roles.id' => $id])
            ->toArray();

        /** @var Resource $resourcesList */
        foreach($resourcesList as $dataForTable) {
            $key = "$dataForTable->controller/$dataForTable->action";
            $ret[$key] = [
                'id' => $dataForTable->id,
                'controller' => $dataForTable->controller,
                'action' => $dataForTable->action,
                'roles' => [],
            ];


            /** @var Role $role */
            foreach($dataForTable->roles as $role) {

                $ret[$key]['roles'][array_search($role['name'], $allRolesName)] = [
                    'id' => $role['id'],
                    'name' => $role['name'],
                    'type' => $role->_joinData['type']
                ];
            };
        };

        dd($ret);

        $this->set(compact('ret'));

    }

    public function editResourceRole($id = null)
    {

    }
}