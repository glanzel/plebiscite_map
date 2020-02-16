<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * StammOrte Controller
 *
 *
 * @method \App\Model\Entity\StammOrte[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StammOrteController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $stammOrte = $this->paginate($this->StammOrte);

        $this->set(compact('stammOrte'));
    }

    /**
     * View method
     *
     * @param string|null $id Stamm Orte id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $stammOrte = $this->StammOrte->get($id, [
            'contain' => [],
        ]);

        $this->set('stammOrte', $stammOrte);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $stammOrte = $this->StammOrte->newEntity();
        if ($this->request->is('post')) {
            $stammOrte = $this->StammOrte->patchEntity($stammOrte, $this->request->getData());
            if ($this->StammOrte->save($stammOrte)) {
                $this->Flash->success(__('The stamm orte has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stamm orte could not be saved. Please, try again.'));
        }
        $this->set(compact('stammOrte'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Stamm Orte id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $stammOrte = $this->StammOrte->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $stammOrte = $this->StammOrte->patchEntity($stammOrte, $this->request->getData());
            if ($this->StammOrte->save($stammOrte)) {
                $this->Flash->success(__('The stamm orte has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stamm orte could not be saved. Please, try again.'));
        }
        $this->set(compact('stammOrte'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Stamm Orte id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $stammOrte = $this->StammOrte->get($id);
        if ($this->StammOrte->delete($stammOrte)) {
            $this->Flash->success(__('The stamm orte has been deleted.'));
        } else {
            $this->Flash->error(__('The stamm orte could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
