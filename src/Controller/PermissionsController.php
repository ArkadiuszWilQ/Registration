<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Resource;
use App\Model\Entity\Role;
use Cake\ORM\TableRegistry;
use function PHPSTORM_META\type;

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
            $this->Flash->error('Błąd');

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

            //już istnejące w bazie danych
            $selectedOptions = TableRegistry::get('ResourcesRoles')
                ->find()
                ->contain('resources')
                ->where(['ResourcesRoles.role_id' => $id, 'ResourcesRoles.type' => $type])
                ->toArray();

            //to co wybrał user
            $resourcesIdsToSave = $this->request->getData('resources_ids');

            //to co było wybrane - id
            $selectedOptionsIds = array_column(array_column($selectedOptions, 'Resources'), 'id');

            if(is_null($selectedOptionsIds) == false) {

                //usuwanie wszystkich
                $resourceRolesTable = TableRegistry::get('ResourcesRoles');
                $resourceRolesTable->deleteAll(['resource_id' => $id, 'type' => $type]);
            }

            if(empty($resourcesIdsToSave) == false) {

                $data = [];
                foreach($resourcesIdsToSave as $value) {
                    $data[] = ['type' => $type, 'resource_id' => $value, 'role_id' => $id];
                }
                // wybrał jakieś do ustawienia więc tu je ustaw
                $resourceRolesTable->saveMany($resourceRolesTable->newEntities($data));

                return $this->redirect(['controller' => 'Permissions', 'action' => 'permissionTable']);
            }

        $this->set(compact('resource', 'id', 'typeList', 'roles', 'type', 'selectedOptionsIds'));

            $this->set(compact('type', 'resources', 'selectedOptionsIds'));
        }

        $this->set(compact('role', 'id'));
    }

    public function editResource($id = null)
    {
        /** @var Resource $resourcesTable */
        $resourcesTable = TableRegistry::get('Resources');
        $resource = $resourcesTable
            ->find()
            ->contain(['Roles'])
            ->where(['Resources.id' => $id])
            ->first();

        if(is_null($resource)) {
            $this->Flash->error('Błąd');

            return $this->redirect(['controller' => 'Permissions', 'action' => 'permissionTable']);
        }

        /** @var Role $rolesInsideResourcesList */
        foreach($resource->roles as $rolesInsideResourcesList) {
            $typeList[$rolesInsideResourcesList->_joinData['type']][$rolesInsideResourcesList->_joinData['id']] = $rolesInsideResourcesList['name'];
        }

        $roles = TableRegistry::get('Roles')
            ->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'])
            ->toArray();

        if($this->request->is('post')) {
            $type = $this->request->getData('type');

            $selectedOptions = TableRegistry::get('ResourcesRoles')
                ->find()
                ->contain('Roles')
                ->where(['ResourcesRoles.resource_id' => $id, 'ResourcesRoles.type' => $type])
                ->toArray();


            //to co wybrał user
            $chosenRolesIds = $this->request->getData('roles_ids');

            //to co było wybrane - id
            $selectedOptionsIds = array_column(array_column($selectedOptions, 'role'), 'id');

            if(is_null($selectedOptionsIds) == false) {

                //usuwanie wszystkich
                $resourceRolesTable = TableRegistry::get('ResourcesRoles');
                $resourceRolesTable->deleteAll(['resource_id' => $id, 'type' => $type]);
            }

            if(empty($chosenRolesIds) == false) {

                $data = [];
                foreach($chosenRolesIds as $value) {
                    $data[] = ['type' => $type, 'resource_id' => $id, 'role_id' => $value];
                }
                // wybrał jakieś do ustawienia więc tu je ustaw
                $resourceRolesTable->saveMany($resourceRolesTable->newEntities($data));

                return $this->redirect(['controller' => 'Permissions', 'action' => 'permissionTable']);
            }
        }
        $this->set(compact('resource', 'id', 'typeList', 'roles', 'type', 'selectedOptionsIds'));
    }

    public function editResourceRole($id = null)
    {

    }
}