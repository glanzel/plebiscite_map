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
		$this->Crud->mapAction('done', 'Crud.View'); 		//TODO: Warum muss das so?
		$this->Crud->mapAction('umap_json', 'Crud.View'); 		//TODO: Warum muss das so?
		$this->Crud->mapAction('deactivate', 'Crud.View'); 		//TODO: Warum muss das so?
		$this->Crud->mapAction('geocode', 'Crud.View'); 		//TODO: Warum muss das so?
		$this->Crud->mapAction('indexJson', 'Crud.Index'); //TODO: Warum muss das so?
		$this->Crud->mapAction('testam', 'Crud.Index'); //TODO: Warum muss das so?
		$this->Crud->mapAction('eingewilligt', 'Crud.Index'); //TODO: Warum muss das so?
		
		$this->Auth->allow(['done','view','umap_json', 'add', 'edit', 'indexJson', 'umapJson']); //TODO: Benutzten wenn es eine Benutzerverwaltung gibt.
	}


	public function beforeFilter(\Cake\Event\Event $event){
		//$this->Crud->disable(['umap_json']).
	    $this->Crud->addListener('Crud.Redirect');
	    $this->Crud->action()->redirectConfig('done',
	        [
	            'reader' => 'request.data',    // Any reader from the list above
	            'key' => '_done',              // The key to check for, passed to the reader
	            'url' => [                     // The url to redirect to
	                'action' => 'done',        // The final url will be '/view/$id'
	            ]
	        ]
	        );
	    parent::beforeFilter($event);
	}
	
	public function indexJson(){
	    //debug($action);
	    return $this->Crud->execute();
	}
	
    public function index(){
        // Your customization and configuration changes here
        
		$action = $this->Crud->action();
		//debug($this->Auth->user('bezirk'));
		$myBezirk = $this->Auth->user('bezirk');
		$this->Crud->action()->setConfig('scaffold.index_finder_scopes', [
		    [
		        'title' => __('All'),
		        'finder' => 'alle',
		    ],
		    [
		        'title' => __('Active'),
		        'finder' => 'active',
		    ],
		    [
		        'title' => __('Inactive'),
		        'finder' => 'inactive',
		    ],
		    [
		        'title' => __('BezirkActive'),
		        'finder' => ['myActive' => ["bezirk" => $myBezirk]]
		    ],
		    [
		        'title' => __('BezirkInactive'),
		        'finder' => ['myInactive' => ["bezirk" => $myBezirk]],
		    ],
		]);
		
		if (! empty ($this->request->getQuery('finder'))) {
    		$this->Crud->action()->config('findMethod', $this->request->getQuery('finder'));
		}else{
		    $this->Crud->action()->config('findMethod', 'alle');
		}
		
		$action->config('scaffold.fields_blacklist', ['id','Details', 'Details_intern', 'Beschreibung', 'Breitengrad']);
		$action->config('scaffold.actions', ['edit', 'view', 'delete']);
		$action->setConfig('scaffold.field_settings', [
		    'active' => [
		        'formatter' => function ($name, $value, $entity, $options, $View) {
		        $yesno = [0 => '<span class="label label-danger">No</span>', 1 => '<span class="label label-success">Yes</span>'];
		        return $View->Html->link($yesno[$value], ['action' => 'deactivate', $entity->id],['escape' => false]);
		        }
		     ],
		     'einwilligung' => [
		         'formatter' => function ($name, $value, $entity, $options, $View) {
		         $yesno = [0 => '<span class="label label-danger">No</span>', 1 => '<span class="label label-success">Yes</span>'];
		         return $View->Html->link($yesno[$value], ['action' => 'eingewilligt', $entity->id],['escape' => false]);
		         }
		         ],
		     'Laengengrad' => [
		         'formatter' => function ($name, $value, $entity, $options, $View) {
		         $isset = empty($value) ? 0 : 1;
		         $yesno2 = [0 => '<span class="label label-danger">No</span>', 1 => '<span class="label label-success">Yes</span>'];
		         return $View->Html->link($yesno2[$isset], ['action' => 'geocode', $entity->id],['escape' => false]);
		         }
		         ]
		         
		]);
		return $this->Crud->execute();
    }
    
    function geocode($id){
        $this->viewBuilder()->setClassName('\Cake\View\View'); //um crud wieder auszuschalten
        $point=$this->Orte->get($id);
        $point = $this->Orte->geocodePoint($point);
        if($point) $this->Orte->save($point);
        else $this->Flash->error(__('Adresse konnte nicht gefunden werden. Geocoordinaten wurde nicht gespeichert.'));
        $this->redirect(['action' => 'index']);
    }

    // activates aswell
    public function deactivate($id){
        $point=$this->Orte->get($id);
        if($point->active == '0'){ 
            if(empty($point->Laengengrad)){ 
                $point = $this->Orte->geocodePoint($point);
                if(! $point) {
                    $this->Flash->error(__('Adresse konnte nicht gefunden werden. Sammelpunkt kann nicht freigeschaltet werden.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
            $point->active='1';
        }
        else $point->active='0';
        $this->Orte->save($point);
        $this->redirect(['action' => 'index']);
    }
    
    public function eingewilligt($id){
        $point=$this->Orte->get($id);
        if($point->einwilligung == '0') $point->einwilligung = '1';
        else $point->einwilligung = '0';
        $this->Orte->save($point);
        $this->redirect(['action' => 'index']);
    }
    
   
	public function view(){
    	$action = $this->Crud->action();
		$action->config('scaffold.field_settings', [
		'Details' =>[ 'formatter' => 'element', 'element' => 'json_view'],
		'Details_intern' =>[ 'formatter' => 'element', 'element' => 'json_view']
		]);
		$action->config('scaffold.actions', []);
        return $this->Crud->execute();
    }     
	
	public function add($embedded = false){
	    if($embedded){ 
	        $this->viewBuilder()->setLayout('content_only');
	    }
	    $this->set('embedded', $embedded);
		$action = $this->Crud->action();
		$action->config('scaffold.fields_blacklist', [ 'Bezirk', 'Details', 'Details_intern', 'Laengengrad', 'Breitengrad', 'active', 'Kategorie', 'created', 'einwilligung']);
		$action->config('scaffold.actions', []);
		$emailValue = $this->Auth->user('id') ? $this->Auth->user('email') : ''; 
		if($this->Auth->user('bezirk')) $this->set('bezirk', $this->Auth->user('bezirk'));
		else $this->set('bezirk', '');
		$action->setConfig('scaffold.field_settings', [
		    'Email' => [
		       'label' => "Email (Wir schicken dir einen Link an deine Email-Adresse, unter dem du den Ort ansehen kannst)",
		        'value' => $emailValue
		    ],
		    'Stadt' => ['value' => "Berlin"]
		]);
    	$this->Crud->on('beforeSave', [$this, '_beforeSave']); //um irgendwas zu ändern
    	$this->Crud->on('afterSave', [$this, '_afterSave']); //um irgendwas zu ändern
    	
        $erg = $this->Crud->execute();
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
	        $this->Flash->error(__('Vielen Dank, der Ort wurde erfolgreich registriert. Um auf der Karte zu erscheinen, muss er noch vom zuständigen Kiezteam freigeschaltet werden.'));
	        list ($point->Breitengrad, $point->Laengengrad)=$coordinates;
	        //debug($point);
	    }		
	    //$this->Log($subject); //Possible Debuging
	    return true;
	}
	
	public function _afterSave(\Cake\Event\Event $event){
	    $point = $event->getSubject()->entity;
	    $this->_sendAddMail($point);
	}
	
	
	protected function _sendAddMail($point){
	    //debug($point->Email);
	    if(! empty($point->Email)){
    	    $email=new \Cake\Mailer\Email('default');
    	    $email->to($point->Email);
    	    $email->setSubject('Dein Sammelpunkt');
    	    $email->setViewVars(['point' => $point]);
    	    $email->viewBuilder()->setTemplate('add_point');
    	    //debug($email);
    	    $email->send();
	    }
	}
	
         

	public function edit(){
        // Your customization and configuration changes here
	    /*
	    $this->Crud->on('afterFind', function(\Cake\Event\Event $event) {
	        debug("Found item: " . $event->getSubject()->entity . " in the database");
	    });
	    */
	    
	    $action = $this->Crud->action();
	    $action->config('scaffold.actions', []);
	    $action->config('scaffold.fields_blacklist', ['Bezirk', 'Details', 'Details_intern', 'Laengengrad', 'Breitengrad', 'active', 'Kategorie', 'created', 'einwilligung']);
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
            $descriptionstring='**'.$point->Strasse.' '.$point->Nr.', '.$point->PLZ.' '.$point->Stadt.'**'." \n*".$point->Beschreibung."*";
            
            if(isset($point->Details['oeffnungszeiten'])) $descriptionstring.= " \n".$point->Details['oeffnungszeiten'];
            if(isset($point->Details['Listenabgabe']) && !empty($point->Details['Listenabgabe']))   $descriptionstring.= " \nListen abgeben:".$point->Details['Listenabgabe'];
            //if(isset($point->Details['Kontakt_Ort']))   $descriptionstring.=  ', Ort_Kontakt:'.$point->Details['Kontakt_Ort'];
            if(isset($point->Details['Kontakt_Kiezteam']) && !empty($point->Details['Kontakt_Kiezteam']))   $descriptionstring.=  " \nKiezteam_Kontakt: ".$point->Details['Kontakt_Kiezteam'];
            
            
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
    
    public function done(){
        $this->viewBuilder()->setClassName('\Cake\View\View'); //um crud wieder auszuschalten
        $this->viewBuilder()->setLayout('content_only');
    }
    
}
