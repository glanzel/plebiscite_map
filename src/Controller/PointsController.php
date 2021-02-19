<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Points Controller
 *
 *
 * @method \App\Model\Entity\Point[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PointsController extends AppController
{

	public function beforeFilter(\Cake\Event\Event $event){
		$this->Auth->allow(['umapJson', 'add']); //TODO: Benutzten wenn es eine Benutzerverwaltung gibt.
		parent::beforeFilter($event);
	}
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    public function umapJson($kategorie=null){

        $points=$this->Points->find()->where(['active' => '1']);       

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
            $descritionstring='**'.$point->Strasse.' '.$point->Nr.', '.$point->PLZ.' '.$point->Stadt.'**'."\n".'*'.$point->Beschreibung.'*';
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

    public function setActive($id)
    {
        $point=$this->Points->get($id);
        $point->active='1';
        $this->Points->save($point);
        $this->redirect(['action' => 'index']);
    }
    
    public function index()
    {
        $points = $this->paginate($this->Points);

        $this->set(compact('points'));
    }

    /**
     * View method
     *
     * @param string|null $id Point id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $point = $this->Points->get($id, [
            'contain' => []
        ]);

        $this->set('point', $point);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $point = $this->Points->newEntity();
        if ($this->request->is('post')) {
            //debug( $this->request->getData());
            $queryString = $this->request->getData()['Strasse'].".".$this->request->getData()['Nr'].", ".$this->request->getData()['PLZ']." ".$this->request->getData()['Stadt'];
            $coordinates =$this->Points->geocoding($queryString);
            if ($coordinates==null){
                $this->Flash->error(__('Adresse konnte nicht gefunden werden. Sammelpunkt wurde nicht gespeichert.'));
                       }
            else{
            list ($point->Breitengrad, $point->Laengengrad)=$coordinates;
            //debug("$breite , $laenge");

            $point = $this->Points->patchEntity($point, $this->request->getData());
            //debug($point);
            //debug( $this->request->getData());

            /* $point->Breitengrad = $breite;
            $point->Laengengrad = $laenge; */

            if ($this->Points->save($point)) {
                $this->Flash->success(__('The point has been saved.'));
                $email=new \Cake\Mailer\Email('default');
                $email->to($point->Email);
                $email->subject('Dein Sammelpunkt');
                $email->setViewVars(['point' => $point]);
                $email->template('add_point');
                $email->emailFormat('html');
                $email->from(['unterschreiben@dwenteignen.de' =>'Deutsche Wohnen und Co enteignen']);
                $email->send();
               return $this->redirect(['action' => 'view', $point->id]);
            }

            $this->Flash->error(__('The point could not be saved. Please, try again.'));
        }
        }
        $this->set(compact('point'));
    }

    public function testsend($id){
       $point=$this->Points->get($id);
        $email=new \Cake\Mailer\Email('default');
                $email->to($point->Email);
                $email->subject('Dein Sammelpunkt');
                $email->setViewVars(['point' => $point]);
                $email->template('add_point');
                $email->emailFormat('html');
                $email->from(['unterschreiben@dwenteignen.de' =>'Deutsche Wohnen und Co enteignen']);
                $email->send();

    }
    

    public function testadd($name='test'){
        $point = $this->Points->newEntity();
        debug($point); 
        $point = $this->Points->patchEntity($point, ["Details" => ["hallo" => "du"]]);
        $details = $point->Details;
        debug($details);
        $point->Details["ahah"] = "bee";
        $point->Details["huhuhu"] = "cool";
        
        $point->Strasse=$name;        
        $point->Nr=5;
        $point->PLZ=5;
        $point->Stadt="bln";
        $point->Name=$name;
        //debug($point);
        $this->Points->save($point);
        
        //debug($this->Points->get($point->id));
        
        //return $this->redirect(['action' => 'testView', $point->id]);
    }

    public function testView($id){
        //debug($this->Points->get($id));
    }

    public function test(){

        $urlString = "http://nominatim.openstreetmap.org";
        $adress = "Werbellinstr.38, 12053 Berlin";
        $queryString = urlencode($adress);
        $urlString = "https://nominatim.openstreetmap.org/search?q=".$queryString."&format=geocodejson";
        debug($urlString);

        $opts = array(
            'http'=>array(
                'header'=>array("Referer: $urlString\r\n")
            )
        );
        $context = stream_context_create($opts);
        $content = file_get_contents($urlString, false, $context);
        $geoObj =  json_decode($content);
        debug($geoObj);
    }

    /**
     * Edit method
     *
     * @param string|null $id Point id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $point = $this->Points->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $point = $this->Points->patchEntity($point, $this->request->getData());
            if ($this->Points->save($point)) {
                $this->Flash->success(__('The point has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The point could not be saved. Please, try again.'));
        }
        $this->set(compact('point'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Point id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $point = $this->Points->get($id);
        if ($this->Points->delete($point)) {
            $this->Flash->success(__('The point has been deleted.'));
        } else {
            $this->Flash->error(__('The point could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    
    public function import($save = false, $team = null, $tag = null){
        $this->viewBuilder()->setClassName('\Cake\View\View'); //um crud wieder auszuschalten
        //$this->set('save', $save);
        $data = $this->request->getQueryParams();
            $schema = $this->getSchema('points');
            if ($this->request->is('post')) {
                $save = isset($this->request->data['import']) ? true : false;
                //$filename = $this->request->data['file']['name']; // NOT needed
                $path = $this->request->data['file']['tmp_name'];
                $this->set('path', $path);
                $csv = file_get_contents($path);
                if( ! mb_detect_encoding($csv, 'UTF-8', true)) $csv = utf8_encode($csv);
                $rows = explode(PHP_EOL, $csv);
                foreach($rows as $key => $row){
                    if(empty($row)) unset($rows[$key]);
                    else $rows[$key] = str_getcsv($row,';');
                }
                $cats = array_shift($rows);
                //debug($cats);
                $newCats = $cats;
                $echo = $save ? "":  "<b>Simuliere importieren:</b><br><br>";
                
                array_multisort($rows);
                //debug($rows);

                foreach($rows as $rowKey => $row){
                    $data = null;
                    foreach($row as $key => $field){
                        if(!isset($data[$newCats[$key]])) $data[$newCats[$key]] = $field;
                        else $data[$newCats[$key]] .= ", $field";
                    }

                    //existiert die zeile bereits ?
                    /*
                    debug($data);
                    $cond = $data;
                    //$cond['created'] = date('Y-m-d'));
                    $query = $this->Points->find('all',['conditions' => $cond]);
                    $register = $query->first();
                    if(!empty($register)){
                        $echo .= ("<b>existiert scheinbar schon:</b> $register->Name $register->Strasse<br>");
                        continue;
                    }
                    */
                    $register = $this->Points->newEntity($data);
                    //debug($register);
                    if(empty($register->Name)){
                        $echo .= "kein Name, kann nichts speichern: $register->Beschreibung<br>";
                        continue;
                    }
                    $register->created = date('Y-m-d H:i:s');
                    if($save){
                        $sregister = $this->Points->save($register);
                    }
                    else $echo .= (" <b>würde speichern:</b> $register->Name $register->Strasse $register->created<br>");
                }
                if($save) $this->Flash->success("Datei wurde erfolgreich gespeichert");
                else $this->set("echo", $echo);
                
            }
        }
        
        public function getSchema($tableName){
            $db = \Cake\Datasource\ConnectionManager::get('default');
            // Create a schema collection.
            $collection = $db->schemaCollection();
            // Get a single table (instance of Schema\TableSchema)
            $tableSchema = $collection->describe($tableName);
            //Get columns list from table
            $columns = $tableSchema->columns();
            return $columns;
        }
        
        public function export($orderBy = 'Name'){
            $this->autoRender = false;
            
            $data = $this->request->getQueryParams();
            
            $options = [];
            $options[ 'fields' ] = ['Name', 'Strasse', 'Nr', 'PLZ', 'Stadt', 'Email', 'Beschreibung'];
            //$options['order'] = $this->Registers->explodeParam($orderBy);
            //debug($options['order']);
            
            if(isset($cond)) $options[ 'conditions' ] = $cond;
            
            $registers = $this->Points->find('all', $options);
            //debug($registers);
            
            $registers = $registers->all()->toArray();
            //debug ($registers);
            $this->response->type('csv');
            $this->response->body($this->str_putcsv($registers));
        }
        
        
        public function fieldMapping($catArray){
            $this->viewBuilder()->setClassName('\Cake\View\View'); //um crud wieder auszuschalten
            foreach($catArray as $key => $cat){
                if(stristr($cat, "datum")) $catArray[$key] = 'belegdatum';
                else if(stristr($cat, "buchungstag")) $catArray[$key] = 'belegdatum';
                else if(stristr($cat, "betrag")) $catArray[$key] = 'einnahme';
                else $catArray[$key] = 'bemerkung';
            }
            return $catArray;
        }   
        
        function str_putcsv($data, $separator = ";") {
            # Generate CSV data from array
            $fh = fopen('php://temp', 'rw'); # don't create a file, attempt
            # to use memory instead
            
            # write out the headers
            fputcsv($fh, array_keys(current($data)->toArray()), $separator);
            
            # write out the data
            foreach ( $data as $row ) {
                //debug($row->toArray());
                fputcsv($fh, $row->toArray(), $separator);
            }
            rewind($fh);
            $csv = stream_get_contents($fh);
            fclose($fh);
            
            return $csv;
        }
           
    
}
