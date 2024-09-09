<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ObrasSociales Controller
 *
 * @property \App\Model\Table\ObrasSocialesTable $ObrasSociales
 */
class ObrasSocialesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ObrasSociales->find();
        $obrasSociales = $this->paginate($query);

        $this->set(compact('obrasSociales'));
    }

    /**
     * View method
     *
     * @param string|null $id Obras Sociale id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $obrasSociale = $this->ObrasSociales->get($id, contain: []);
        $this->set(compact('obrasSociale'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $obrasSociale = $this->ObrasSociales->newEmptyEntity();
        if ($this->request->is('post')) {
            $obrasSociale = $this->ObrasSociales->patchEntity($obrasSociale, $this->request->getData());
            if ($this->ObrasSociales->save($obrasSociale)) {
                $this->Flash->success(__('The obras sociale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The obras sociale could not be saved. Please, try again.'));
        }
        $this->set(compact('obrasSociale'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Obras Sociale id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $obrasSociale = $this->ObrasSociales->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $obrasSociale = $this->ObrasSociales->patchEntity($obrasSociale, $this->request->getData());
            if ($this->ObrasSociales->save($obrasSociale)) {
                $this->Flash->success(__('The obras sociale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The obras sociale could not be saved. Please, try again.'));
        }
        $this->set(compact('obrasSociale'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Obras Sociale id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $obrasSociale = $this->ObrasSociales->get($id);
        if ($this->ObrasSociales->delete($obrasSociale)) {
            $this->Flash->success(__('The obras sociale has been deleted.'));
        } else {
            $this->Flash->error(__('The obras sociale could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
