<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Estados Controller
 *
 * @property \App\Model\Table\EstadosTable $Estados
 */
class EstadosController extends AppController
{
    protected array $paginate = [
        'limit' => 10,
        'order' => [
            'Estados.nombre' => 'asc',
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
        $estados = $this->Estados->find()
            ->where($conditions['where'])
            ->contain($conditions['contain']);

        $this->set('filters', $this->getRequest()->getQuery());
        $this->set('estados', $this->paginate($estados));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $estado = $this->Estados->newEmptyEntity();
        if ($this->request->is('post')) {
            $estado = $this->Estados->patchEntity($estado, $this->request->getData());
            if ($this->Estados->save($estado)) {
                $this->Flash->success(__('El estado se guardo correctamente.'));

                return $this->redirect('/Estados/index');
            }
            $this->Flash->error(__('El estado no pudo ser guardada. Por favor, verifique los campos e intenete nuevamente.'));
        }
        $this->set(compact('estado'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Estado id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $estado = $this->Estados->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estado = $this->Estados->patchEntity($estado, $this->request->getData());
            if ($this->Estados->save($estado)) {
                $this->Flash->success(__('El estado se actualizo correctamente.'));

                return $this->redirect('/Estados/index');
            }
            $this->Flash->error(__('El estado no pudo ser guardada. Por favor, verifique los campos e intenete nuevamente.'));
        }
        $this->set(compact('estado'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Estado id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $estado = $this->Estados->get($id);
        if ($this->Estados->delete($estado)) {
            $this->Flash->success(__('El estado ha sido eliminada.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el estado. Por favor, inténtalo de nuevo.'));
        }

        return $this->redirect('/Estados/index');
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
            $conditions['where'][] = ['Estados.nombre LIKE' => '%' . $data['nombre'] . '%'];
        }

        if (isset($data['activo'])) {
            $conditions['where'][] = ['Estados.activo' => $data['activo']];
        } else {
            $conditions['where'][] = ['Estados.activo' => 1];
        }

        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());

        return $conditions;
    }
}
