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
		$this->Crud->mapAction('login', ['className' => 'App\Crud\Action\MyLoginAction']);
		$this->Crud->mapAction('register', 'CrudUsers.Register');
		$this->Crud->mapAction('logout', 'CrudUsers.Logout');
		$this->Crud->mapAction('erstellen', 'Crud.View');
		$this->Crud->mapAction('forgotPassword','CrudUsers.ForgotPassword');
		$this->Crud->mapAction('resetPassword','CrudUsers.ResetPassword');
		$this->Crud->mapAction('verify','CrudUsers.Verify');
		$this->Crud->mapAction('activate', 'CrudUsers.Logout'); 		//TODO: Warum muss das so?
		$this->Auth->allow(['register', 'erstellen', "verify", "forgotPassword", "resetPassword"]);
		//$this->Crud->disable(['login']);

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
	        debug($user);
	        $this->_sendRegisterMail($user, [ "action" => "verify", "_full" => true,  $user->token, $user->id, "subject" => "Bitte verifiziere nun deinen Emailadresse" ] );
	    });
		
		return $this->Crud->execute();
    }
    
    public function verify($token = null, $user_id = null ){
        debug($token);
        $this->Crud->on('verifyToken', function(\Cake\Event\Event $event) {
            debug($this->Users->getActivationHash($event->getSubject()->entity));
            debug($event->subject());
            if($event->subject()->token == $this->Users->getActivationHash($event->getSubject()->entity)){
                $event->subject()->entity->verified = 1;
                //debug($event->subject()->entity);
                $this->Users->save($event->subject()->entity);
                return true;
            }
            
        });
        return $this->Crud->execute();
    }
    
    public function login(){
        //$this->viewBuilder()->setClassName('\Cake\View\View'); //um crud wieder auszuschalten
        //$this->Crud->action()->disable();
		
/*		if($this->request->isPost()){
		    if ($user = $this->Users->Auth->identify()) {
    		    debug($user);
		        
		    }
		        
		}
*/	
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
            /*habe mir den Code hier drüber nicht erschließen können. 
            ist after.. eine crud-Funktionalität? Und ermöglicht
            die Erzeugung eines tokens nach Aufruf der Seiten/Methode?*/
            $email=new \Cake\Mailer\Email('default');
	        $email->to($user->email);
            $email->setSubject('Passwort zurücksetzen');
            $email->setViewVars(['user' => $user]);
            $email->viewBuilder()->setTemplate('reset_pw');
	        $email->send();
	    });
	    return $this->Crud->execute();
	}
	
	public function resetPassword($token){
	    $this->Crud->action()->config("tokenField", "token");
	    $this->Crud->on('verifyToken', function(\Cake\Event\Event $event) {
	       /*
	        debug($event->getSubject());
	        debug($event->subject()->token);
	        debug($this->Users->getActivationHash($event->getSubject()->entity));
	        */
	        if($event->subject()->token == $this->Users->getActivationHash($event->getSubject()->entity)){ 
	            //debug($event->getSubject()->entity);
	            //debug($this->Users->getActivationHash($event->getSubject()->entity));
	            $event->subject()->verified = 1;
	            $event->getSubject()->entity->verified = 1;
	            $event->getSubject()->entity->token = "00000";
	        }
	        
	    });
	    return $this->Crud->execute();
	}
	
	protected function _sendRegisterMail($user, $linkArr = null, $subject = "Benutzer registriert",  $template = "register_user" ){
	    $email=new \Cake\Mailer\Email('default');
	    $email->to($user->email);
	    $email->setSubject($subject);
	    $email->setViewVars(['user' => $user, 'linkArr' => $linkArr]);
	    $email->viewBuilder()->setTemplate($template);
	    //debug($email);
	    $email->send();
	}

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {    	
        $action = $this->Crud->action();
        $action->config('scaffold.fields_blacklist', ['id', 'password', 'token']);
        $action->config('scaffold.actions', ['activate', 'view', 'delete']);
        return $this->Crud->execute();
    }
    
    public function activate($id){
        $user=$this->Users->get($id);
        $user->active='1';
        $this->Users->save($user);
        $this->redirect(['action' => 'index']);
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
    public function edit($id = null){
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
