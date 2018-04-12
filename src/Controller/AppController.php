<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use App\Model\Entity\ResourcesRole;
use App\Model\Entity\Role;
use App\Model\Entity\User;
use App\Model\Table\UsersRolesTable;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /** @var User|null */
    private $loggedUser;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'viewClassMap' => [
                'json' => 'ApiKit.MyJson',
                'xml' => 'ApiKit.MyXml',
                'csv' => 'ApiKit.Csv'
            ]
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password',
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],

            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'authorize' => 'Controller'
        ]);


    }

    public function isAuthorized($user): bool
    {

        $controller = $this->request->getParam('controller');
        $action = $this->request->getParam('action');

        //jeśli $this->config[$controller][$action] nie ma wartości, przypisany jest null
        $currentConfig = $this->getConfigForRequest($controller, $action);

        if($this->isAdmin()) {
            return true;
        }

        if(is_null($currentConfig)) {
            //domyślna akcja w przypadku braku konfiguracji
            return true;
        }

        //jeśli znajdzie się rola usera w denny
        foreach($currentConfig['denny'] ?? [] as $denny) {
            if(in_array($denny, $this->getLoggedUserRoles())) {
                return false;
            }
        }

        //jeśli nie znajdują się wszystkie role usera w require
        foreach($currentConfig['require'] ?? [] as $require) {
            if(in_array($require, $this->getLoggedUserRoles()) === false) {
                return false;
            }
        }

        if(empty($currentConfig['one_of_many'] ?? [])) {
            return true;
        }

        //jeśli znajduje się chociaż jedna rola w one_of_many
        foreach($currentConfig['one_of_many'] ?? [] as $one_of_many) {
            if(in_array($one_of_many, $this->getLoggedUserRoles())) {
                return true;
            }
        }

        return false;
    }

    public function isAdmin()
    {
        $rolesTable = TableRegistry::get('UsersRoles');
        $rolesList = $rolesTable
            ->find()
            ->select(['user_id', 'roles.name'])
            ->join([
                'table' => 'Roles',
                'conditions' => 'UsersRoles.role_id = Roles.id'
            ])
            ->where(['UsersRoles.user_id' => $this->Auth->user('id'), 'roles.name = "admin"'])
            ->first();

        return $rolesList;
    }

    public function getConfig()
    {
        $resourcesRolesTable = TableRegistry::get('ResourcesRoles');
        $resourcesRolesList = $resourcesRolesTable
            ->find()
            ->contain(['Resources', 'Roles'])
            ->toArray();

        $dynamicConfig = [];

        /** @var ResourcesRole $resourcesRole */
        foreach($resourcesRolesList as $resourcesRole) {
            $controller = ucfirst(strtolower($resourcesRole->resource->controller));
            $action = strtolower($resourcesRole->resource->action);
            $type = strtolower($resourcesRole->type);
            $dynamicConfig[$controller][$action][$type][] = $resourcesRole->role->id;
        }

        return $dynamicConfig;
    }

    public function getConfigForRequest(string $controller, string $action)
    {
        $resourcesRolesTable = TableRegistry::get('ResourcesRoles');
        $resourcesRolesList = $resourcesRolesTable
            ->find()
            ->contain(['Resources', 'Roles'])
            ->innerJoin(['Resources' => "resources"], ['ResourcesRoles.resource_id = Resources.id'])
            ->where(["Resources.controller" => strtolower($controller), "Resources.action" => strtolower($action)])
            ->toArray();

        if(empty($resourcesRolesList)) {
            $resourcesRolesList = $resourcesRolesTable
                ->find()
                ->contain(['Resources', 'Roles'])
                ->innerJoin(['Resources' => "resources"], ['ResourcesRoles.resource_id = Resources.id'])
                ->where(["Resources.controller" => strtolower($controller), "Resources.action" => "*"])
                ->toArray();

            if(empty($resourcesRolesList)) {
                return null;
            }
        }

//    if(empty($resourcesRolesList)) {
//            return null;
//        }

        $dynamicConfig = [];

        /** @var ResourcesRole $resourcesRole */
        foreach($resourcesRolesList as $resourcesRole) {
            $dynamicConfig[strtolower($resourcesRole->type)][] = $resourcesRole->role->id;
        }

        return $dynamicConfig;
    }

    /**
     * @return array
     */
    private function getLoggedUserRoles(): array
    {
        $ret = [];

        /** @var Role $role */
        foreach($this->getLoggedUser()->roles as $role) {
            $ret[] = $role->id;
        }

        return $ret;
    }

    /**
     * @return User
     */
    public function getLoggedUser()
    {
        if(is_null($this->loggedUser)) {
            $usersTable = TableRegistry::get('Users');

            $user = $usersTable
                ->find()
                ->contain(['Roles'])
                ->where(['id' => $this->Auth->user('id')])
                ->first();

            $this->loggedUser = $user;
        }

        return $this->loggedUser;
    }
}