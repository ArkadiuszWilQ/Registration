<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Role;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['register', 'reset']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if($this->request->is('post')) { //sprawdzenie czy był post
            $user = $this->Auth->identify(); //próbuje zidentyfikować usera po danych w poscie

            if($user) { // kiedy user jest prawidłowy, przekazyje dane

                if($user['status'] == 0) { //jeśli status usera jest równy 0
                    $this->Flash->error('Konto jest nieaktywne'); //Wyświetla komunikat błędu
                    return;
                }

                if($user['status'] == 2) { //jeśli status usera jest równy 2
                    $this->Flash->error('Konto zostało usunięte'); //Wyświetla komunikat błędu
                    return;
                }

                $this->Auth->setUser($user); //Ustawia dostarczone dane jako dane do zalogowania
                return $this->redirect($this->Auth->redirectUrl()); //Przekierowuje tam gdzie user zostanie przerzucony po zalogowaniu
            }

            $this->Flash->error('Błędny login lub hasło'); //Wyświetla komunikat błędu
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }


    public function register()
    {
        if($this->request->is('post')) {
            $user = $this->Users->newEntity();
            $user->status = 1;
            $user->email = $this->request->getData('email');
            $user->password = $this->request->getData('password');

            if($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                $this->Auth->setUser($user);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
    }

    public function reset()
    {
        $usersRoles = TableRegistry::get('UsersRoles');
        $roles = TableRegistry::get('Roles');

        if($this->request->is('post')) {
            if($this->request->getData(['password']) == 'test') {
                $usersRoles->deleteAll([]);
                $this->Users->deleteAll([]);
                $this->redirect($this->Auth->logout());

                $user = $this->Users->newEntity();
                $user->status = 1;
                $user->email = 'admin@test.pl';
                $user->password = 'admin';
                $user->roles = $roles->find()->toArray();
                $this->Users->save($user);

                for($i = 1; $i < 10; $i++) {
                    $user = $this->Users->newEntity();
                    $user->status = rand(0, 2);
                    $user->email = 'test' . $i . '@test.pl';
                    $user->password = 'test' . $i;

                    $this->Users->save($user);

                }
            }
        }
    }

    public function export()
    {
        $this->response->download('Export_Users.csv');
        $data = $this->Users
            ->find()
            ->select(['id', 'status', 'email', 'registration_date'])
            ->toArray();
        $_serialize = 'data';
        $_header = ['ID', 'Status', 'Email', 'Created Date'];
        $this->set(compact('data', '_serialize', '_header'));
        $this->viewBuilder()->className('CsvView.Csv');
        return;

    }

}
