<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Termine Controller
 *
 *
 * @method \App\Model\Entity\Termine[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TermineController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $query = $this->Termine->find()->contain(['StammOrte']);
        
        $termine = $this->paginate($query);
        
        foreach ($termine as $termin){
        debug($termin->stamm_orte->ort);
        }
        $this->set(compact('termine'));
    }

    /**
     * View method
     *
     * @param string|null $id Termine id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $termine = $this->Termine->get($id, [
            'contain' => [],
        ]);

        $this->set('termine', $termine);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $termine = $this->Termine->newEntity();
        if ($this->request->is('post')) {
            /*Todo: Die Felder aus TerminDetails und Stammorte befüllen, ich schätze so:

            $termine = $this->Termine->patchEntity($termine, $this->request->getData(), [
                'associated' => ['TerminDetails', 'StammOrte']);*/
            $termine = $this->Termine->patchEntity($termine, $this->request->getData());
            if ($this->Termine->save($termine)) {
                $this->Flash->success(__('Dein Termin wurde eingetragen.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Dein Termin konnte nicht gespeichert werden. Bitte versuche es noch einmal.'));
        }
        $this->set(compact('termine'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Termine id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $termine = $this->Termine->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $termine = $this->Termine->patchEntity($termine, $this->request->getData());
            if ($this->Termine->save($termine)) {
                $this->Flash->success(__('The termine has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The termine could not be saved. Please, try again.'));
        }
        $this->set(compact('termine'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Termine id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $termine = $this->Termine->get($id);
        if ($this->Termine->delete($termine)) {
            $this->Flash->success(__('The termine has been deleted.'));
        } else {
            $this->Flash->error(__('The termine could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
