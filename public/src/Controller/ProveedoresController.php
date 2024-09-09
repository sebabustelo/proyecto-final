<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Proveedores Controller
 *
 * @property \App\Model\Table\ProveedoresTable $Proveedores
 */
class ProveedoresController extends AppController
{
    protected array $paginate = [
        'limit' => 10,
        'order' => [
            'Proveedores.nombre' => 'asc',
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
        $proveedores = $this->Proveedores->find()
            ->where($conditions['where'])
            ->contain($conditions['contain']);

        $this->set('filters', $this->getRequest()->getQuery());
        $this->set('proveedores', $this->paginate($proveedores));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $proveedor = $this->Proveedores->newEmptyEntity();
        if ($this->request->is('post')) {
            $proveedore = $this->Proveedores->patchEntity($proveedor, $this->request->getData());
            if ($this->Proveedores->save($proveedor)) {
                $this->Flash->success(__('The proveedore has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The proveedore could not be saved. Please, try again.'));
        }
        $this->set(compact('proveedor'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Proveedore id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $proveedore = $this->Proveedores->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $proveedore = $this->Proveedores->patchEntity($proveedore, $this->request->getData());
            if ($this->Proveedores->save($proveedore)) {
                $this->Flash->success(__('The proveedore has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The proveedore could not be saved. Please, try again.'));
        }
        $this->set(compact('proveedore'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Proveedore id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $proveedor = $this->Proveedores->get($id);
        if ($this->Proveedores->delete($proveedor)) {
            $this->Flash->success(__('The proveedore has been deleted.'));
        } else {
            $this->Flash->error(__('The proveedore could not be deleted. Please, try again.'));
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
            $conditions['where'][] = ['Proveedores.nombre LIKE' => '%' . $data['nombre'] . '%'];
        }

        if (isset($data['cuit']) and !empty($data['cuit'])) {
            $conditions['where'][] = ['Proveedores.cuit ' => $data['cuit']];
        }

        if (isset($data['email']) and !empty($data['email'])) {
            $conditions['where'][] = ['Proveedores.email LIKE' => '%' . $data['email'] . '%'];
        }

        if (isset($data['activo'])) {
            $conditions['where'][] = ['Proveedores.activo' => $data['activo']];
        } else {
            $conditions['where'][] = ['Proveedores.activo' => 1];
        }

        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());

        return $conditions;
    }
}
