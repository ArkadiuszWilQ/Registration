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

//        $resourcesTable = TableRegistry::get('Resources');
//        $resourcesList = $resourcesTable
//            ->find()
//            ->select(['controller', 'action', 'ResourcesRoles.type'])
//            ->join([
//                'alias' => 'ResourcesRoles',
//                'table' => 'resources_roles',
//                'type' => 'LEFT',
//                'conditions' => 'Resources.id = ResourcesRoles.resource_id'
//            ])
//            ->toArray();

        $resourcesList = $resourcesTable
            ->find()
            ->contain(['Roles'])
            ->toArray();

//        dd([
//            $resourcesList2[0]->roles[0]->name,
//            $resourcesList2[0]->roles[0]->_joinData->type,
//            $resourcesList,
//            $resourcesList2,
//        ]);
        //foreach w foreachu bez kluczy
//        /** @var Resource $resourcesList */
//        foreach($resourcesList2 as $dataForTable) {
//            $temp = [
//                'Controller' => $dataForTable->controller,
//                'Action' => $dataForTable->action,
//                'Roles' => ['test'],
//            ];
//
//            foreach($dataForTable->roles as $roles) {
//                $temp['Roles'][] = 1;
//            };
//
//            $table[] = $temp;
//        };

        /** @var Resource $resourcesList */
        foreach($resourcesList as $dataForTable) {
            $key = "$dataForTable->controller/$dataForTable->action";
            $ret[$key] = [
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




        /**
         * dd($allRolesName) daje
         * 	(int) 0 => 'users_add',
        (int) 1 => 'users_edit',
        (int) 2 => 'users_delete',
        (int) 3 => 'admin',
        (int) 4 => 'roles_add',
        (int) 5 => 'roles_edit',
        (int) 6 => 'roles_delete',
        (int) 7 => 'add_users',
        (int) 8 => 'edit_users',
        (int) 9 => 'delete_users',
        (int) 10 => 'add_roles',
        (int) 11 => 'edit_roles',
        (int) 12 => 'delete_roles',
        (int) 13 => 'export_users'
         */


        $this->set(compact('allRolesName'));
        $this->set(compact('controllerAndActionField'));
        $this->set(compact('ret'));



        //STARY KOD
//        $ret = [];
//
//        foreach($table as $data) {
//            //Nadaniei zmienner $resource formy controller/action
//            $resource = $data['Controller'] . DS . $data['Action'];
//
//            if(array_key_exists($resource, $ret) == false) {
//                    $ret[$resource] = [
//                        'Controller' => $data['Controller'],
//                        'Action' => $data['Action'],
//                        'Type' => []
//                    ];
//            }
//
//            $ret[$resource]['Type'][] = $data['Type'];
//
//        };
//


        //kod na wzór
        /** * foreach($keywordsResults as $keywordData) {
         * $keyword = $keywordData['keyword'];
         *
         * if(array_key_exists($keyword, $data) == false) {
         * $data[$keyword] = [
         * 'kid' => $keywordData['kid'],
         * 'keyword' => $keyword,
         * 'searches' => $keywordData['searches'],
         * 'common_factor' => 0
         * ];
         * }
         *
         * $data[$keyword]['common_factor']++;
         * }
         **/
    }
}
