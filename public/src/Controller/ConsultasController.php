<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Consultas Controller
 *
 * @property \App\Model\Table\ConsultasTable $Consultas
 */
class ConsultasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Consultas->find();
        $consultas = $this->paginate($query);

        $this->set(compact('consultas'));
    }

    /**
     * View method
     *
     * @param string|null $id Consulta id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $consulta = $this->Consultas->get($id, contain: []);
        $this->set(compact('consulta'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $consulta = $this->Consultas->newEmptyEntity();
        if ($this->request->is('post')) {
            $consulta = $this->Consultas->patchEntity($consulta, $this->request->getData());
            if ($this->Consultas->save($consulta)) {
                $this->Flash->success(__('The consulta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consulta could not be saved. Please, try again.'));
        }
        $this->set(compact('consulta'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Consulta id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $consulta = $this->Consultas->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $consulta = $this->Consultas->patchEntity($consulta, $this->request->getData());
            if ($this->Consultas->save($consulta)) {
                $this->Flash->success(__('The consulta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consulta could not be saved. Please, try again.'));
        }
        $this->set(compact('consulta'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Consulta id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $consulta = $this->Consultas->get($id);
        if ($this->Consultas->delete($consulta)) {
            $this->Flash->success(__('The consulta has been deleted.'));
        } else {
            $this->Flash->error(__('The consulta could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}