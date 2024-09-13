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
    protected array $paginate = [
        'limit' => 10,
        'order' => [
            'ObrasSociales.nombre' => 'asc',
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
        $obrasSociales = $this->ObrasSociales->find()
            ->where($conditions['where'])
            ->contain($conditions['contain']);

        $this->set('filters', $this->getRequest()->getQuery());
        $this->set('obrasSociales', $this->paginate($obrasSociales));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $obraSocial = $this->ObrasSociales->newEmptyEntity();
        if ($this->request->is('post')) {
            $obraSocial = $this->ObrasSociales->patchEntity($obraSocial, $this->request->getData());
            if ($this->ObrasSociales->save($obraSocial)) {
                $this->Flash->success(__('La obra social se guardo correctamente.'));

                return $this->redirect('/ObrasSociales/index');
            }
            $this->Flash->error(__('La obra social no pudo ser guardada. Por favor, verifique los campos e intenete nuevamente.'));
        }
        $this->set(compact('obraSocial'));
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
        $obraSocial = $this->ObrasSociales->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $obraSocial = $this->ObrasSociales->patchEntity($obraSocial, $this->request->getData());
            if ($this->ObrasSociales->save($obraSocial)) {
                $this->Flash->success(__('La obra social se actualizo correctamente.'));

                return $this->redirect('/ObrasSociales/index');
            }
            $this->Flash->error(__('La obra social no pudo ser guardada. Por favor, verifique los campos e intenete nuevamente.'));
        }
        $this->set(compact('obraSocial'));
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
        $obraSocial = $this->ObrasSociales->get($id);
        if ($this->ObrasSociales->delete($obraSocial)) {
            $this->Flash->success(__('La obra social ha sido eliminada.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar la obra social. Por favor, inténtalo de nuevo.'));
        }

        return $this->redirect('/ObrasSociales/index');
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

        if (isset($data['cuit']) and !empty($data['email'])) {
            $conditions['where'][] = ['ObrasSociales.cuit LIKE ' => '%' . $data['cuit'] . '%'];
        }

        if (isset($data['nombre']) and !empty($data['nombre'])) {
            $conditions['where'][] = ['ObrasSociales.nombre LIKE' => '%' . $data['nombre'] . '%'];
        }

        if (isset($data['email']) and !empty($data['email'])) {
            $conditions['where'][] = ['ObrasSociales.email LIKE ' => '%' . $data['email'] . '%'];
        }

        if (isset($data['activo'])) {
            $conditions['where'][] = ['ObrasSociales.activo' => $data['activo']];
        } else {
            $conditions['where'][] = ['ObrasSociales.activo' => 1];
        }

        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());

        return $conditions;
    }
}
