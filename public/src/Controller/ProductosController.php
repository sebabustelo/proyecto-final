<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Productos Controller
 *
 * @property \App\Model\Table\ProductosTable $Productos
 */
class ProductosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Productos->find()
            ->contain(['Categorias', 'Proveedores']);
        $productos = $this->paginate($query);

        $this->set(compact('productos'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function catalogoCliente()
    {
        $query = $this->Productos->find()
            ->contain(['Categorias', 'Proveedores']);
        $productos = $this->paginate($query);

        $this->set(compact('productos'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $producto = $this->Productos->newEmptyEntity();
        if ($this->request->is('post')) {
            debug($_FILES);
            debug($this->request->getData());die;
            $producto = $this->Productos->patchEntity($producto, $this->request->getData());
            if ($this->Productos->save($producto)) {
                $this->Flash->success(__('The producto has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The producto could not be saved. Please, try again.'));
        }
        $categorias = $this->Productos->Categorias->find('list', limit: 200)->all();
        $proveedores = $this->Productos->Proveedores->find('list', limit: 200)->all();
        $this->set(compact('producto', 'categorias', 'proveedores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Producto id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $producto = $this->Productos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $producto = $this->Productos->patchEntity($producto, $this->request->getData());
            if ($this->Productos->save($producto)) {
                $this->Flash->success(__('The producto has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The producto could not be saved. Please, try again.'));
        }
        $categorias = $this->Productos->Categorias->find('list', limit: 200)->all();
        $proveedores = $this->Productos->Proveedores->find('list', limit: 200)->all();
        $this->set(compact('producto', 'categorias', 'proveedores'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Producto id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $producto = $this->Productos->get($id);
        if ($this->Productos->delete($producto)) {
            $this->Flash->success(__('The producto has been deleted.'));
        } else {
            $this->Flash->error(__('The producto could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
