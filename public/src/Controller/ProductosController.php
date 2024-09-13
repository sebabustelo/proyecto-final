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
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Upload');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $conditions = $this->getConditions();
        $productos = $this->Productos->find()
            ->where($conditions['where'])
            ->contain($conditions['contain']);

        $this->set('filters', $this->getRequest()->getQuery());
        $this->set('productos', $this->paginate($productos));

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
           // debug( count($_FILES['imagenes']['name']));
            // debug($_FILES);
           //  debug($this->request->getData());
           // die;
            $producto = $this->Productos->patchEntity($producto, $this->request->getData());

            if ($this->Productos->save($producto)) {

                $files = $this->request->getData('imagenes');
                $result = $this->Upload->uploadMultiple($files, WWW_ROOT . 'img/productos/');

                if ($result['status']) {
                    //La primer imagen es la principal
                    $principal = true;
                    foreach ($result['files'] as $file) {
                        $upload = $this->Productos->ProductosArchivos->newEmptyEntity();
                        $upload->product_id = $producto->id;
                        $upload->file_name = $file['file_name'];
                        $upload->file_extension = $file['file_extension'];
                        $upload->file_size = $file['file_size'];
                        $upload->file_path = $file['file_path'];
                        $upload->producto_id = $producto->id;
                        if($principal){
                            $upload->es_principal = 1;
                            $principal = false;
                        }
                        $this->Productos->ProductosArchivos->save($upload);
                    }
                    $this->Flash->success(__('El producto se guardo correctamente.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error($result['error']);
                }
            }
            $this->Flash->error(__('El producto no pudo ser guardado. Por favor, verifique los campos e intenete nuevamente.'));
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
        $producto = $this->Productos->get($id, contain: ['ProductosArchivos']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $producto = $this->Productos->patchEntity($producto, $this->request->getData());
            debug($producto);
            debug( $this->request->getData());die;
            if ($this->Productos->save($producto)) {
                $this->Flash->success(__('El producto se actualizo correctamente.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo eliminar el producto. Por favor, inténtalo de nuevo.'));
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
            $this->Flash->success(__('El producto ha sido eliminado.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el producto. Por favor, inténtalo de nuevo.'));
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
        $conditions['contain'] =['Categorias', 'Proveedores', 'ProductosArchivos'];

        if (isset($data['nombre']) and !empty($data['nombre'])) {
            $conditions['where'][] = ['Productos.nombre LIKE' => '%' . $data['nombre'] . '%'];
        }

        if (isset($data['descripcion_breve']) and !empty($data['descripcion_breve'])) {
            $conditions['where'][] = ['Productos.descripcion_breve LIKE ' => '%' . $data['descripcion_breve'] . '%'];
        }

        if (isset($data['activo'])) {
            $conditions['where'][] = ['Productos.activo' => $data['activo']];
        } else {
            $conditions['where'][] = ['Productos.activo' => 1];
        }

        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());

        return $conditions;
    }
}
