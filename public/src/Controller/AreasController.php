<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\DateTime;
use \Cake\ORM\Query\SelectQuery;

/**
 * Areas Controller
 *
 * @property \App\Model\Table\AreasTable $Areas
 */
class AreasController extends AppController
{
    protected array $paginate = [
        'limit' => PAGINATION_LIMIT,
        'order' => [
            'Areas.codigo' => 'asc',
        ],
    ];

    public function _null()
    {
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $conditions = $this->getConditions($this->getRequest()->getQuery());
        $areas = $this->Areas->find()->where($conditions['where'])->contain($conditions['contain']);
        $this->set('areas', $this->paginate($areas));
        $this->set('filters', $this->getRequest()->getQuery());
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $area = $this->Areas->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['activo'] = 1;
            $area = $this->Areas->patchEntity($area, $data);
            if ($this->Areas->save($area)) {
                $this->Flash->success(__('El Área se guardo exitosamente.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('El área no pudo ser guardada. Por favor, resuelva los errores e intente nuevamente.'));
        }
        $this->set(compact('area'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $area = $this->Areas->get($id, contain: ['Resoluciones' => function (SelectQuery $query) {
            return $query->select(['Resoluciones.area_id', 'cantidad' => $query->func()->count('id')]);
        }]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $area = $this->Areas->patchEntity($area, $this->request->getData());
            if ($this->Areas->save($area)) {
                $this->Flash->success(__('El Área se guardo exitosamente.'));
                $previousUrl = $this->request->getSession()->read('previousUrl');
                return $this->redirect($previousUrl);
            }
            $this->Flash->error(__('El área no pudo ser guardada. Por favor, resuelva los errores e intente nuevamente.'));
        }
        $this->set(compact('area'));
    }

    /**
     * View method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $area = $this->Areas->get($id, contain: ['Resoluciones']);
        $this->set(compact('area'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $area = $this->Areas->get($id, contain: ['Resoluciones']);

        $resoluciones = count($area['resoluciones']);
        if ($resoluciones > 0) {
            if ($resoluciones == 1) {
                $this->Flash->error(__('No se puede eliminar el Área, esta asociada una Resolución. Si quiere puede editar el área y desactivarla para que no aparezca en futuras altas de Resoluciones.'));
            } else {
                $this->Flash->error(__('No se puede eliminar el Área, esta asociada a Resoluciones. Si quiere puede editar el área y desactivarla para que no aparezca en futuras altas de Resoluciones.'));
            }
        } else {
            if ($this->Areas->delete($area)) {
                $this->Flash->success(__('El Área se elimino correctamente.'));
            } else {
                $this->Flash->error(__('El Área no se puede eliminar.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * getConditions method
     *
     * @param string|null $data Data send by the Form for the method GET .
     * @return array $conditions Conditions for search filters.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function getConditions($data)
    {
        $conditions['where'] = [];
        $conditions['matching'] = [];

        $conditions['contain'] =     ['Resoluciones' => function (SelectQuery $query) {
            return $query->select(['Resoluciones.area_id', 'cantidad' => $query->func()->count('id')])->groupBy('area_id');
        }];

        if (isset($data['codigo']) and !empty($data['codigo'])) {
            $conditions['where'][] = ['Areas.codigo LIKE' => '%' . $data['codigo'] . '%'];
        }

        if (isset($data['descripcion']) and !empty($data['descripcion'])) {
            $conditions['where'][] = ['Areas.descripcion LIKE ' => '%' . $data['descripcion'] . '%'];
        }

        if (isset($data['activo'])) {
            $conditions['where'][] = ['Areas.activo' => $data['activo']];
        } else {
            $conditions['where'][] = ['Areas.activo' => 1];
        }
        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());
        return $conditions;
    }

    public function deleteLogic($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $area = $this->Areas->get($id);
        $session = $this->request->getSession();

        $area->deleted = DateTime::now();
        $area->deleted_by = $session->read('RbacUsuario.id');
        $area->activo = 0;

        if ($this->Areas->save($area)) {
            $this->Flash->success(__('La baja logica del Area se realizo con exito.'));
        } else {
            $this->Flash->error(__('El Área no se pudo eliminar.Por favor, verifique los campos.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Recover method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function recover($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $area = $this->Areas->get($id);
        //$session = $this->request->getSession();

        $area->deleted = NULL;
        $area->deleted_by = NULL;
        $area->activo = 1;
        //debug($area);

        if ($this->Areas->save($area)) {
            $this->Flash->success(__('El Area se recupero exitosamente.'));
        } else {
            $this->Flash->error(__('El Área no se pudo recuperar.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
