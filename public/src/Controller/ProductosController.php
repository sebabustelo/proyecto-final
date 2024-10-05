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
     * catalogoCliente method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function catalogoCliente()
    {
        $conditions = $this->getConditionsPublic();
        $productos = $this->Productos->find()
            ->where($conditions['where'])
            ->contain([
                'Categorias',
                'ProductosArchivos',
                'ProductosPrecios' => function ($q) {
                    return $q->where(['fecha_hasta IS NULL'])->order(['ProductosPrecios.fecha_desde' => 'DESC']); // Ordenar por fecha_desde en orden ascendente
                }
            ]);

        $this->set('productos', $this->paginate($productos));
        $this->set('filters', $this->getRequest()->getQuery());
    }

    public function detail($id = null)
    {
        $producto = $this->Productos->find()
            ->where(['Productos.id' => $id])
            ->contain([
                'Categorias',
                'ProductosArchivos',
                'ProductosPrecios' => function ($q) {
                    return $q->order(['ProductosPrecios.fecha_desde' => 'DESC']);
                }
            ])
            ->first();

        if (!$producto) {
            $this->Flash->error(__('El producto no existe.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('producto'));
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
            $data = $this->request->getData();
            $data['productos_precios'][0]['fecha_desde'] =  date('Y-m-d H:i:s'); // Fecha actual

            $producto = $this->Productos->patchEntity(
                $producto,
                $data,
                [
                    'associated' => [
                        'ProductosPrecios'
                    ],
                ]
            );

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
                        if ($principal) {
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
            } else {
                debug($producto->getErrors());
                die;
                if ($producto->getErrors()) {
                    foreach ($producto->getErrors() as $field => $errors) {
                        foreach ($errors as $error) {
                            $this->Flash->error(__($error));
                        }
                    }
                } else {
                    $this->Flash->error(__('El producto no pudo ser guardado. Por favor, verifique los campos e intenete nuevamente.'));
                }
            }
        }
        $categorias = $this->Productos->Categorias->find('list')->where(['Categorias.activo' => 1])->all();
        $proveedores = $this->Productos->Proveedores->find('list')->where(['Proveedores.activo' => 1])->all();
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
        $producto = $this->Productos->find()
            ->where(['Productos.id' => $id]) // Filtrar por el ID del producto
            ->contain([
                'ProductosArchivos',
                'ProductosPrecios' => function ($q) {
                    return $q->order(['ProductosPrecios.fecha_desde' => 'DESC']); // Ordenar por fecha_desde en orden ascendente
                }
            ])
            ->first(); // Retorna el primer registro encontrado


        if ($this->request->is(['patch', 'post', 'put'])) {
            $data =  $this->request->getData();


            if ($data['productos_precios'][0]['precio'] != $producto->productos_precios[0]->precio) {
                // Obtener el precio actual del producto
                $precioActual = $producto->productos_precios[0];

                // Actualizar la fecha_hasta del precio existente
                $precioActual->fecha_hasta =  date('Y-m-d H:i:s'); // Fecha actual

                // Guardar el precio existente con la fecha_hasta actualizada
                if ($this->Productos->ProductosPrecios->save($precioActual)) {
                    // Crear un nuevo precio
                    $nuevoPrecio = $this->Productos->ProductosPrecios->newEntity([
                        'producto_id' => $producto->id,
                        'precio' => $data['productos_precios'][0]['precio'],
                        'fecha_desde' => date('Y-m-d H:i:s'), // Fecha actual
                        'fecha_hasta' => null // Mantener como null hasta que haya un cambio futuro
                    ]);

                    // Guardar el nuevo precio
                    if ($this->Productos->ProductosPrecios->save($nuevoPrecio)) {
                        $this->Flash->success(__('Nuevo precio guardado con éxito.'));
                    } else {
                        if ($nuevoPrecio->getErrors()) {
                            foreach ($nuevoPrecio->getErrors() as $field => $errors) {
                                foreach ($errors as $error) {
                                    $this->Flash->error(__($error));
                                }
                            }
                        } else {
                            $this->Flash->error(__('No se pudo guardar el nuevo precio.'));
                        }
                    }
                } else {
                    $this->Flash->error(__('No se pudo actualizar el precio anterior.'));
                }
            }

            // Eliminar productos_precios de los datos antes de guardar el producto
            unset($data['productos_precios']);
            $producto = $this->Productos->patchEntity($producto, $data);

            if ($this->Productos->save($producto)) {
                $this->Flash->success(__('El producto se actualizo correctamente.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo eliminar el producto. Por favor, inténtalo de nuevo.'));
        }
        $categorias = $this->Productos->Categorias->find('list')->where(['Categorias.activo' => 1])->all();
        $proveedores = $this->Productos->Proveedores->find('list')->where(['Proveedores.activo' => 1])->all();
        $this->set(compact('producto', 'categorias', 'proveedores'));
    }


    /**
     * Categorias method
     *
     * @param string|null $id Categosrias id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function categorias($id = null)
    {
        $categoria = $this->Productos->Categorias->get($id);
        $productos = $this->Productos->find()->where(['categoria_id' => $id])->contain(['Categorias', 'ProductosArchivos'])->all();
        $this->set(compact('productos', 'categoria'));
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
        $conditions['contain'] = ['Categorias', 'Proveedores', 'ProductosArchivos'];

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

    /**
     * getCondition method
     *
     * @param string|null $data Data send by the Form .
     * @return array $conditions Conditions for search filters with $conditions['where'], $conditions['contain'] and $conditions['matching'] to find.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function getConditionsPublic()
    {
        $data = $this->getRequest()->getQuery();

        $conditions['where'] = [];
        $conditions['contain'] = ['Categorias', 'ProductosArchivos'];

        if(!isset($data['search'])){
            $data['search']='';
        }

        $orConditions = [];
        $orConditions[] = ['Productos.nombre LIKE' => '%' . $data['search'] . '%'];
        $orConditions[] = ['Productos.descripcion_breve LIKE ' => '%' . $data['search'] . '%'];
        $conditions['where']['OR'] = $orConditions;

        return $conditions;
    }
}
