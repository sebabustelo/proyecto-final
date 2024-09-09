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
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tipoDocumento = $this->TipoDocumentos->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['descripcion'] = strtoupper($data['descripcion']);
            $tipoDocumento = $this->TipoDocumentos->patchEntity($tipoDocumento, $data);

            if ($this->TipoDocumentos->save($tipoDocumento)) {
                $this->Flash->success(__('El Tipo de Documento se guardo correctamente.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El Tipo de Documento no pudo ser guardado. Por favor, verifique los campos e intenete nuevamente.'));
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
            $data = $this->request->getData();
            $data['descripcion'] = strtoupper($data['descripcion']);
            $tipoDocumento = $this->TipoDocumentos->patchEntity($tipoDocumento, $data);
            if ($this->TipoDocumentos->save($tipoDocumento)) {
                $this->Flash->success(__('El Tipo de Documento se guardo correctamente.'));


                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El Tipo de Documento no pudo ser guardado. Por favor, verifique los campo e intenete nuevamente.'));
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
            foreach ($tipoDocumento->getErrors() as $field => $errors) {
                foreach ($errors as $error) {
                    $this->Flash->error(__($error));
                }
            }
        }

        return $this->redirect(['action' => 'index']);
    }
}
