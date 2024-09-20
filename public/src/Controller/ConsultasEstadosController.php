<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ConsultasEstados Controller
 *
 * @property \App\Model\Table\ConsultasEstadosTable $ConsultasEstados
 */
class ConsultasEstadosController extends AppController
{
    protected array $paginate = [
        'limit' => 10,
        'order' => [
            'ConsultasEstados.nombre' => 'asc',
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
        $consultasEstados = $this->ConsultasEstados->find()
            ->where($conditions['where'])
            ->contain($conditions['contain']);

        $this->set('filters', $this->getRequest()->getQuery());
        $this->set('estados', $this->paginate($consultasEstados));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $estado = $this->ConsultasEstados->newEmptyEntity();
        if ($this->request->is('post')) {
            $estado = $this->ConsultasEstados->patchEntity($estado, $this->request->getData());
            if ($this->ConsultasEstados->save($estado)) {
                $this->Flash->success(__('El estado de consulta se guardo correctamente.'));

                return $this->redirect('/ConsultasEstados/index');
            }
            $this->Flash->error(__('El estado de consultas no pudo ser guardada. Por favor, verifique los campos e intenete nuevamente.'));
        }
        $this->set(compact('estado'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Consultas Estado id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $estado = $this->ConsultasEstados->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estado = $this->ConsultasEstados->patchEntity($estado, $this->request->getData());
            if ($this->ConsultasEstados->save($estado)) {
                $this->Flash->success(__('El estado de consulta se actualizo correctamente.'));

                return $this->redirect('/ConsultasEstados/index');
            }
            $this->Flash->error(__('El estado de consulta no pudo ser guardada. Por favor, verifique los campos e intenete nuevamente.'));
        }
        $this->set(compact('estado'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Consultas Estado id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $estado = $this->ConsultasEstados->get($id);
        if ($this->ConsultasEstados->delete($estado)) {
            $this->Flash->success(__('El estado de consulta ha sido eliminada.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el estado de consulta. Por favor, inténtalo de nuevo.'));
        }

        return $this->redirect('/ConsultasEstados/index');
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
            $conditions['where'][] = ['ConsultasEstados.nombre LIKE' => '%' . $data['nombre'] . '%'];
        }

        if (isset($data['activo'])) {
            $conditions['where'][] = ['ConsultasEstados.activo' => $data['activo']];
        } else {
            $conditions['where'][] = ['ConsultasEstados.activo' => 1];
        }

        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());

        return $conditions;
    }
}
