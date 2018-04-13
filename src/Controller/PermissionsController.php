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
            ->select(['name'])
            ->where( ['id' => $id])
            ->first();

        $this->set(compact('role'));


    }

    public function editResource($id = null)
    {

    }

    public function editResourceRole($id = null)
    {

    }
}