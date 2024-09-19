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
    protected array $paginate = [
        'limit' => 10,
        'order' => [
            'Consultas.created' => 'asc',
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
        $consultas = $this->Consultas->find()
            ->where($conditions['where'])
            ->contain($conditions['contain']);

        $this->set('filters', $this->getRequest()->getQuery());
        $this->set('consultas', $this->paginate($consultas));
        $this->set('estados', $this->Consultas->ConsultasEstados->find('all')->all());

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
            $estadoPendiente = $this->Consultas->ConsultasEstados->find('all')
                ->where(['ConsultasEstados.nombre' => 'PENDIENTE'])
                ->first();

            if ($estadoPendiente) {
                $consulta->consulta_estado_id = $estadoPendiente->id;
            }


            $consulta = $this->Consultas->patchEntity($consulta, $this->request->getData());
            if ($this->Consultas->save($consulta)) {
                $this->Flash->success(__('Su consulta fue enviada correctamente, le responderemos a la brevedad.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('La consulta no pudo ser enviada. Por favor intenete nuevamente.'));
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
    public function response($id = null)
    {
        $consulta = $this->Consultas->get($id, contain: ['Cliente']);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $consulta->usuario_respuesta_id = $_SESSION['RbacUsuario']['id'];
            $consulta = $this->Consultas->patchEntity($consulta, $this->request->getData());


            // debug($consulta);die;
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
        $conditions['contain'] = ['Cliente', 'UsuarioRespuesta', 'ConsultasEstados'];

        if (isset($data['nombre']) and !empty($data['nombre'])) {
            $conditions['where'][] = ['Consultas.usuario_id LIKE' => '%' . $data['nombre'] . '%'];
        }

        if (isset($data['descripcion']) and !empty($data['descripcion'])) {
            $conditions['where'][] = ['Consultas.motivo LIKE ' => '%' . $data['descripcion'] . '%'];
        }

        if (isset($data['consulta_estado_id']) and !empty($data['consulta_estado_id'])) {
            $conditions['where'][] = ['Consultas.consulta_estado_id ' => $data['consulta_estado_id'] ];
        }


        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());

        return $conditions;
    }
}
