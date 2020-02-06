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
		$this->Crud->mapAction('umap_json', 'CrudUsers.Logout'); 		//TODO: Warum muss das so?
		$this->Crud->mapAction('activate', 'CrudUsers.Logout'); 		//TODO: Warum muss das so?
		
		$this->Auth->allow(['umap_json', 'add']); //TODO: Benutzten wenn es eine Benutzerverwaltung gibt.
	}


	public function beforeFilter(\Cake\Event\Event $event){
		//$this->Crud->disable(['umap_json']).
		parent::beforeFilter($event);
	}
	
    public function index(){
        // Your customization and configuration changes here
		$action = $this->Crud->action();
		$action->config('scaffold.fields_blacklist', ['id','Details', 'Details_intern']);
		$action->config('scaffold.actions', ['activate', 'edit', 'view', 'delete']);
        return $this->Crud->execute();
    }     
    
    public function activate($id){	
        $point=$this->Orte->get($id);
        $point->active='1';
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
		$action->config('scaffold.fields_blacklist', ['Details', 'Details_intern', 'Laengengrad', 'Breitengrad', 'active', 'Kategorie']);

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
	        //debug("$breite , $laenge");
	    }		
	    //$this->Log($subject); //Possible Debuging
	    return true;
	}	    
         

	public function edit()
    {
        // Your customization and configuration changes here
        return $this->Crud->execute();
    }     

     
    public function umapJson($kategorie=null){
		$this->viewBuilder()->setClassName('\Cake\View\View'); //um crud wieder auszuschalten
        $points=$this->Orte->find();

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
            $descritionstring='**'.$point->Strasse.' '.$point->Nr.', '.$point->PLZ.' '.$point->Stadt.'**'.' *'.$point->Beschreibung.'*';
            $jsonpoint['properties']['description'] = $descritionstring;
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
    
}
