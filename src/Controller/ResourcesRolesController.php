<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ResourcesRoles Controller
 *
 * @property \App\Model\Table\ResourcesRolesTable $ResourcesRoles
 *
 * @method \App\Model\Entity\ResourcesRole[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ResourcesRolesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Resources', 'Roles']
        ];
        $resourcesRoles = $this->paginate($this->ResourcesRoles);

        $this->set(compact('resourcesRoles'));
    }

    /**
     * View method
     *
     * @param string|null $id Resources Role id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $resourcesRole = $this->ResourcesRoles->get($id, [
            'contain' => ['Resources', 'Roles']
        ]);

        $this->set('resourcesRole', $resourcesRole);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $resourcesRole = $this->ResourcesRoles->newEntity();
        if ($this->request->is('post')) {
            $resourcesRole = $this->ResourcesRoles->patchEntity($resourcesRole, $this->request->getData());
            if ($this->ResourcesRoles->save($resourcesRole)) {
                $this->Flash->success(__('The resources role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The resources role could not be saved. Please, try again.'));
        }
//        $resources = $this->ResourcesRoles->Resources->find('list');
        $roles = $this->ResourcesRoles->Roles->find('list');

        $resources = $this->ResourcesRoles->Resources->find();
        $resources
            ->select([
                'value' => 'Resources.id',
                'label' => $resources->func()->concat([
                    'Resources.controller' => 'identifier',
                    '/',
                    'Resources.action' => 'identifier'
                ])
            ])
            ->orderAsc('Resources.id');

       $resourcesOptions = array_column($resources->toArray(), 'label', 'value');

        $this->set(compact('resourcesRole', 'resources', 'roles', 'resourcesOptions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Resources Role id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $resourcesRole = $this->ResourcesRoles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $resourcesRole = $this->ResourcesRoles->patchEntity($resourcesRole, $this->request->getData());
            if ($this->ResourcesRoles->save($resourcesRole)) {
                $this->Flash->success(__('The resources role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The resources role could not be saved. Please, try again.'));
        }
        $resources = $this->ResourcesRoles->Resources->find('list', ['limit' => 200]);
        $roles = $this->ResourcesRoles->Roles->find('list', ['limit' => 200]);
        $this->set(compact('resourcesRole', 'resources', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Resources Role id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $resourcesRole = $this->ResourcesRoles->get($id);
        if ($this->ResourcesRoles->delete($resourcesRole)) {
            $this->Flash->success(__('The resources role has been deleted.'));
        } else {
            $this->Flash->error(__('The resources role could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}