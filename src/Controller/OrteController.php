<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Points Controller
 *
 *
 * @method \App\Model\Entity\Point[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrteController extends CrudAppController
{
	
	public function initialize(){
		parent::initialize();
		//$this->Crud->mapAction('testam', 'CrudUsers.Logout'); 		//TODO: Warum muss das so?
		$this->Crud->mapAction('umap_json', 'Crud.View'); 		//TODO: Warum muss das so?
		$this->Crud->mapAction('deactivate', 'Crud.View'); 		//TODO: Warum muss das so?
		$this->Crud->mapAction('indexJson', 'Crud.Index'); 		//TODO: Warum muss das so?
		
		$this->Auth->allow(['umap_json', 'add', 'index', 'indexJson', 'umapJson']); //TODO: Benutzten wenn es eine Benutzerverwaltung gibt.
	}


	public function beforeFilter(\Cake\Event\Event $event){
		//$this->Crud->disable(['umap_json']).
		parent::beforeFilter($event);
	}
	
	public function indexJson(){
	    //debug($action);
	    return $this->Crud->execute();
	    	    
	}
	
    public function index(){
        // Your customization and configuration changes here
        
		$action = $this->Crud->action();
		$action->config('scaffold.fields_blacklist', ['id','Details', 'Details_intern', 'Laengengrad', 'Breitengrad']);
		$action->config('scaffold.actions', ['edit', 'view', 'delete']);
		$action->setConfig('scaffold.field_settings', [
		    'active' => [
		        'formatter' => function ($name, $value, $entity, $options, $View) {
		        $yesno = [0 => '<span class="label label-danger">No</span>', 1 => '<span class="label label-success">Yes</span>'];
		        return $View->Html->link($yesno[$value], ['action' => 'deactivate', $entity->id],['escape' => false]);
		        }
		     ]
		]);
        return $this->Crud->execute();
    }     

    // activates aswell
    public function deactivate($id){
        $point=$this->Orte->get($id);
        if($point->active == '0') $point->active='1';
        else $point->active='0';
        $this->Orte->save($point);
        $this->redirect(['action' => 'index']);
    }
    
	public function view(){
    	$action = $this->Crud->action();
		$action->config('scaffold.field_settings', [
		'Details' =>[ 'formatter' => 'element', 'element' => 'json_view'],
		'Details_intern' =>[ 'formatter' => 'element', 'element' => 'json_view']
		]);
        return $this->Crud->execute();
    }     
	
	public function add(){
		$action = $this->Crud->action();
		$action->config('scaffold.fields_blacklist', ['Details', 'Details_intern', 'Laengengrad', 'Breitengrad', 'active', 'Kategorie', 'created']);

    	$this->Crud->on('beforeSave', [$this, '_beforeSave']); //um irgendwas zu ändern
    	
        $this->Crud->execute();
    }
    
    public function _beforeSave(\Cake\Event\Event $event){
        $this->Log($event); //Possible Debuging
	    $point = $event->getSubject()->entity;
	    $this->Log($point); //Possible Debuging
	    $queryString = $point->Strasse.".".$point->Nr.", ".$point->PLZ." ".$point->Stadt;
	    $coordinates =$this->Orte->geocoding($queryString);

	    if ($coordinates==null){
	        $this->Flash->error(__('Adresse konnte nicht gefunden werden. Sammelpunkt wurde nicht gespeichert.'));
	        return false;
	    }
	    else{
	        list ($point->Breitengrad, $point->Laengengrad)=$coordinates;
	        $this->_sendAddMail($point);
	        //debug("$breite , $laenge");
	    }		
	    //$this->Log($subject); //Possible Debuging
	    return true;
	}
	
	protected function _sendAddMail($point){
	    $email=new \Cake\Mailer\Email('default');
	    $email->to($point->Email);
	    $email->setSubject('Dein Sammelpunkt');
	    $email->setViewVars(['point' => $point]);
	    $email->viewBuilder()->setTemplate('add_point');
	    //debug($email);
	    $email->send();
	}
	
         

	public function edit(){
        // Your customization and configuration changes here
	    $action = $this->Crud->action();
	    $action->config('scaffold.fields_blacklist', ['Details', 'Details_intern', 'Laengengrad', 'Breitengrad', 'active', 'Kategorie', 'created']);
	    return $this->Crud->execute();
    }     

    public function delete(){
        return $this->Crud->execute();
    }
     
    public function umapJson($kategorie=null){
		$this->viewBuilder()->setClassName('\Cake\View\View'); //um crud wieder auszuschalten
		$points=$this->Orte->find()->where(['active' => '1']);
		
        $jsonpoints=[];
        $jsonpoints['type']='FeatureCollection';
        $jsonpoints['features']=[];
        foreach ($points as $point)
        {
            $jsonpoint=[];
            $jsonpoint['type']='Feature';
            $jsonpoint['properties']=[];
            $jsonpoint['properties']['name']=$point->Name;
            $jsonpoint['properties']['beschreibung']=$point->Beschreibung;
            $jsonpoint['properties']['street']=$point->Strasse;
            $jsonpoint['properties']['Nr']=$point->Nr;
            $jsonpoint['properties']['PLZ']=$point->PLZ;
            $jsonpoint['properties']['adress']=$point->Stadt;
            //String, der an "Description" weitergegeben werden soll (Adressdaten fett, Beshreibung kursiv)
            $descriptionstring='**'.$point->Strasse.' '.$point->Nr.', '.$point->PLZ.' '.$point->Stadt.'**'.' *'.$point->Beschreibung.'*';
            $jsonpoint['properties']['description'] = $descriptionstring;
            $jsonpoint['geometry']=[];

            $jsonpoint['geometry']['type']='Point';
            $jsonpoint['geometry']['coordinates']=[$point->Breitengrad,$point->Laengengrad];
            $jsonpoints['features'][] = $jsonpoint;
        }
        $this->autoRender = false;
        $jsonpoints=json_encode($jsonpoints);
        //$this->set('points', $jsonpoints);
		$this->response->type('json');
		$this->response->body($jsonpoints);
        $this->set('_serialize', true);
    }

    /**
     * View method
     *
     * @param string|null $id Point id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.


 
	//scheint nicht zu funktionieren
    public function testAdd(){
		$this->Crud->mapAction('testAdd', 'Crud.Add');
		$action = $this->Crud->action();
    	$this->Crud->on('beforeSave', [$this, '_beforeSave']); //um irgendwas zu ändern
		debug($action);
		$this->request->data = 
		[
		'id' => '',
		'Name' => 'ein name',
		'Strasse' => 'Boddinstr',
		'Nr' => '12',
		'PLZ' => '12053',
		'Stadt' => 'Berlin',
		'Beschreibung' => '',
		'Details' => [
			'oeffnungszeiten' => '13-14',
			'Listanabgabe' => 'ja'
		],
		'Details_intern' => [
			'Treffpunkt' => 'ja'
		],
		'_save' => '1'
		];
		debug($this->request->getData());
		$this->Crud->execute();
	}
    */
    
    public function testam($id = "58818e5b-1948-4651-a471-ee9da1b6bff2"){
        $this->viewBuilder()->setClassName('\Cake\View\View'); //um crud wieder auszuschalten
        $point = $this->Orte->get($id);
        debug($point);
        $this->_sendAddMail($point);
    }
    
}
