<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * TipoDocumentos Controller
 *
 * @property \App\Model\Table\TipoDocumentosTable $TipoDocumentos
 */
class TipoDocumentosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->TipoDocumentos->find();
        $tipoDocumentos = $this->paginate($query);

        $this->set(compact('tipoDocumentos'));
    }

    /**
     * View method
     *
     * @param string|null $id Tipo Documento id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tipoDocumento = $this->TipoDocumentos->get($id, contain: ['RbacUsuarios']);
        $this->set(compact('tipoDocumento'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tipoDocumento = $this->TipoDocumentos->newEmptyEntity();
        if ($this->request->is('post')) {
            $tipoDocumento = $this->TipoDocumentos->patchEntity($tipoDocumento, $this->request->getData());
            if ($this->TipoDocumentos->save($tipoDocumento)) {
                $this->Flash->success(__('El Tipo de Documento se guardo exitosamente.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El Tipo de Documento no pudo ser guardado. Por favor, verifique los campo e intenete nuevamente.'));
        }
        $this->set(compact('tipoDocumento'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tipo Documento id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tipoDocumento = $this->TipoDocumentos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tipoDocumento = $this->TipoDocumentos->patchEntity($tipoDocumento, $this->request->getData());
            if ($this->TipoDocumentos->save($tipoDocumento)) {
                $this->Flash->success(__('El Tipo de Documento se guardo exitosamente.'));


                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El Tipo de Documento no pudo ser guardado. Por favor, verifique los campo e intenete nuevamente o envie un mail a soporte.'));
        }
        $this->set(compact('tipoDocumento'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tipo Documento id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tipoDocumento = $this->TipoDocumentos->get($id);
        if ($this->TipoDocumentos->delete($tipoDocumento)) {
            $this->Flash->success(__('El Tipo de Documento se elimino correctamente.'));
        } else {
            $this->Flash->error(__('El Tipo de Documento no pudo ser eliminado. Por favor, intente nuevamente o envie un mail a soporte.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
