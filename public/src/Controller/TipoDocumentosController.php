<?php

declare(strict_types=1);

namespace App\Controller;


use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Exception\MethodNotAllowedException;

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
        $conditions = $this->getConditions();
        $tipoDocumentos = $this->TipoDocumentos->find()
            ->where($conditions['where'])
            ->contain($conditions['contain']);

        $this->set('filters', $this->getRequest()->getQuery());
        $this->set('tipoDocumentos', $this->paginate($tipoDocumentos));
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
                $this->Flash->success(__('El Tipo de Documento se guardó correctamente.'));
                return $this->redirect(['action' => 'index']);
            }

            foreach ($tipoDocumento->getErrors() as $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    $this->Flash->error($error);
                }
            }
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
        try {
            $tipoDocumento = $this->TipoDocumentos->get($id, contain: []);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $data = $this->request->getData();
                $data['descripcion'] = strtoupper($data['descripcion']);
                $tipoDocumento = $this->TipoDocumentos->patchEntity($tipoDocumento, $data);
                if ($this->TipoDocumentos->save($tipoDocumento)) {
                    $this->Flash->success(__('El Tipo de Documento se guardo correctamente.'));
                    return $this->redirect(['action' => 'index']);
                }

                foreach ($tipoDocumento->getErrors() as $fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        $this->Flash->error($error);
                    }
                }
            }
            $this->set(compact('tipoDocumento'));
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('El tipo de documento no existe.'));
            return $this->redirect(['controller' => 'TipoDocumentos', 'action' => 'index']);
        }
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

        try {
            $this->request->allowMethod(['post', 'delete']);
            $tipoDocumento = $this->TipoDocumentos->get($id);

            if ($this->TipoDocumentos->delete($tipoDocumento)) {
                $this->Flash->success(__('El Tipo de Documento se elimino correctamente.'));
            } else {
                if ($tipoDocumento->getErrors()) {
                    foreach ($tipoDocumento->getErrors() as $field => $errors) {
                        foreach ($errors as $error) {
                            $this->Flash->error(__($error));
                        }
                    }
                }
            }
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('El tipo de documento no existe.'));
        } catch (MethodNotAllowedException $e) {
            $this->Flash->error(__('Método HTTP no permitido.'));
        }

        return $this->redirect(['controller' => 'TipoDocumentos', 'action' => 'index']);
    }

    /**
     * getCondition method
     *
     * @param string|null $data Data send by the Form .
     * @return array $conditions Conditions for search filters with $conditions['where'], $conditions['contain'] and $conditions['matching'] to find.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function getConditions()
    {
        $data = $this->getRequest()->getQuery();
        $conditions['where'] = [];
        $conditions['contain'] = [];

        if (isset($data['descripcion']) and !empty($data['descripcion'])) {
            $conditions['where'][] = ['TipoDocumentos.descripcion LIKE ' => '%' . $data['descripcion'] . '%'];
        }

        if (isset($data['activo'])) {
            $conditions['where'][] = ['TipoDocumentos.activo' => $data['activo']];
        } else {
            $conditions['where'][] = ['TipoDocumentos.activo' => 1];
        }

        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());

        return $conditions;
    }
}
