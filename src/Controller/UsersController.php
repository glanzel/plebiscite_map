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
		$this->Crud->mapAction('forgotPassword','CrudUsers.ForgotPassword');
		$this->Crud->mapAction('resetPassword','CrudUsers.ResetPassword');
		$this->Crud->mapAction('verify','CrudUsers.Verify');
		
		$this->Auth->allow(['register', 'erstellen', "verify", "forgotPassword", "resetPassword"]);

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
		
		$this->Crud->on('beforeRegister', function(\Cake\Event\Event $event) {
		    $user = $event->getSubject()->entity;
		    $user->token = $this->Users->getActivationHash($user);
		});
	    $this->Crud->on('afterRegister', function(\Cake\Event\Event $event) {
	        $user = $event->getSubject()->entity;
            $this->Users->_senRegisterMail($user);
	    });
		
		return $this->Crud->execute();
    }
    
    public function verify($id = null, $token = null){
        $this->Crud->on('verifyToken', function(\Cake\Event\Event $event) {
            if($event->subject()->token == $this->Users->getActivationHash($event->getSubject()->entity)) $event->subject()->verified = true;
        });
            return $this->Crud->execute();
    }
    
    public function login(){
		$this->Crud->action()->enable();
		return $this->Crud->execute();
	}

	public function logout(){
	    return $this->Crud->execute();
	}
	
	public function forgotPassword(){
	    $this->Crud->on('afterForgotPassword', function(\Cake\Event\Event $event) {
	        $user = $event->getSubject()->entity;
	        $user->token = $this->Users->getActivationHash($user);
	        $this->Users->save($user);
	        //TODO: Send Email.
	    });
	    return $this->Crud->execute();
	}
	
	public function resetPassword($token){
	    $this->Crud->action()->config("tokenField", "token");
	    $this->Crud->on('verifyToken', function(\Cake\Event\Event $event) {
	        debug($event->subject()->token);
	        if($event->subject()->token == $this->Users->getActivationHash($event->getSubject()->entity)){ 
	            $event->subject()->verified = true;
	            $event->getSubject()->entity->verified = true;
	            $event->getSubject()->entity->token = "00000";
	        }
	        
	    });
	        
	    return $this->Crud->execute();
	}
	
	protected function _sendRegisterMail($user, $subject = "Benutzer registiert",  $template = "register_user"){
	    $email=new \Cake\Mailer\Email('default');
	    $email->to($user->Email);
	    $email->setSubject($subject);
	    $email->setViewVars(['user' => $user]);
	    $email->viewBuilder()->setTemplate($template);
	    debug($email);
	    $email->send();
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
