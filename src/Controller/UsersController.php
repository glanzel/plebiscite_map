<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends CrudAppController{
	

	public function initialize(){
		parent::initialize();
		$this->Crud->mapAction('login', 'CrudUsers.Login');
		$this->Crud->mapAction('register', 'CrudUsers.Register');
		$this->Crud->mapAction('logout', 'CrudUsers.Logout');
		$this->Crud->mapAction('erstellen', 'Crud.View');
		
		$this->Auth->allow(['register', 'erstellen']);

	}

    public function erstellen(){
		$this->viewBuilder()->setClassName('\Cake\View\View'); //um crud wieder auszuschalten
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->getData());
			$this->Users->save($user);
		}
    }
    public function register(){
		$this->Crud->action()->enable();
		return $this->Crud->execute();
    }
    public function login(){
		$this->Crud->mapAction('login', 'CrudUsers.Login');
		$this->Crud->action()->enable();
		return $this->Crud->execute();
	}
    

	


    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
		
        return $this->Crud->execute();
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        return $this->Crud->execute();
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        return $this->Crud->execute();
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        return $this->Crud->execute();
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
        return $this->Crud->execute();
    }
}
