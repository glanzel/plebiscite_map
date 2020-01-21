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
		//$this->Auth->allow(['index']); //TODO: Benutzten wenn es eine Benutzerverwaltung gibt.
	}
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    public function index($kategorie=null){

        $points=$this->Points->find();

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
            //TODO: gocoding
            debug($this->Points);
            $queryString = $this->request->getData()['Strasse'].".".$this->request->getData()['Nr'].", ".$this->request->getData()['PLZ']." ".$this->request->getData()['Stadt'];
            $coordinates =$this->Points->geocoding($queryString);
            if ($coordinates==null){
                $this->Flash->error(__('Adresse konnte nicht gefunden werden. Sammelpunkt wurde nicht gespeichert.'));
                       }
            else{
            list ($point->Breitengrad, $point->Laengengrad)=$coordinates;
            //debug("$breite , $laenge");

            $point = $this->Points->patchEntity($point, $this->request->getData());

            /* $point->Breitengrad = $breite;
            $point->Laengengrad = $laenge; */

            if ($this->Points->save($point)) {
                $this->Flash->success(__('The point has been saved.'));

                return $this->redirect(['action' => 'view', $point->id]);
            }

            $this->Flash->error(__('The point could not be saved. Please, try again.'));
        }
        }
        $this->set(compact('point'));
    }

    public function testadd($name='test'){
        $point = $this->Points->newEntity();
        $point = $this->Points->patchEntity($point, ["Details" => ["hallo" => "du"]]);
        $point->Details = [];
        $point->Details["ahah"] = "bee";
        $point->Strasse=$name;        
        $point->Nr=5;
        $point->PLZ=5;
        $point->Stadt="bln";
        $point->Name=$name;
        debug($point);
        $this->Points->save($point);
        
        debug($this->Points->get($point->id));
        
        //return $this->redirect(['action' => 'testView', $point->id]);
    }

    public function testView($id){
        debug($this->Points->get($id));
    }

    public function test(){

        $urlString = "http://nominatim.openstreetmap.org";
        $adress = "Flughafenstr.38, 12053 Berlin";
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


        debug($content);
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
}
