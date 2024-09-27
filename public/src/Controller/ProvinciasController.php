<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Provincias Controller
 *
 * @property \App\Model\Table\ProvinciasTable $Provincias
 */
class ProvinciasController extends AppController
{
    protected array $paginate = [
        'limit' => 10,
        'order' => [
            'Provincias.nombre' => 'asc',
        ],
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $conditions = $this->getConditions();
        $provincias = $this->Provincias->find()
            ->where($conditions['where'])
            ->contain($conditions['contain']);

        $this->set('filters', $this->getRequest()->getQuery());
        $this->set('provincias', $this->paginate($provincias));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $provincia = $this->Provincias->newEmptyEntity();
        if ($this->request->is('post')) {
            $provincia = $this->Provincias->patchEntity($provincia, $this->request->getData());
            if ($this->Provincias->save($provincia)) {
                $this->Flash->success(__('La provincia se guardo correctamente.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La provincia no pudo ser guardada. Por favor, verifique los campos e intenete nuevamente.'));
        }
        $this->set(compact('provincia'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Provincia id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $provincia = $this->Provincias->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $provincia = $this->Provincias->patchEntity($provincia, $this->request->getData());
            if ($this->Provincias->save($provincia)) {
                $this->Flash->success(__('La categoría se actualizo correctamente.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La categoría no pudo ser guardada. Por favor, verifique los campos e intenete nuevamente.'));
        }
        $this->set(compact('provincia'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Provincia id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $provincia = $this->Provincias->get($id);

        if ($this->Provincias->delete($provincia)) {
            $this->Flash->success(__('La provincia ha sido eliminada.'));
        } else {
            if ($provincia->getErrors()) {
                foreach ($provincia->getErrors() as $field => $errors) {
                    foreach ($errors as $error) {
                        $this->Flash->error(__($error));
                    }
                }
            } else {
                $this->Flash->error(__('No se pudo eliminar la provincia . Por favor, inténtalo de nuevo.'));
            }
        }

        return $this->redirect(['action' => 'index']);
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

        if (isset($data['nombre']) and !empty($data['nombre'])) {
            $conditions['where'][] = ['Provincias.nombre LIKE' => '%' . $data['nombre'] . '%'];
        }

        if (isset($data['activo'])) {
            $conditions['where'][] = ['Provincias.activo' => $data['activo']];
        } else {
            $conditions['where'][] = ['Provincias.activo' => 1];
        }

        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());

        return $conditions;
    }
}
