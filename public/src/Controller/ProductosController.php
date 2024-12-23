<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Exception\MethodNotAllowedException;

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

    protected array $paginate = [
        'limit' => 8,
        'order' => [
            'Productos.nombre' => 'asc',
        ],
    ];

    public function test(){

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
     * Método detail
     *
     * Este método permite obtener y mostrar los detalles de un producto específico.
     * Utiliza el ID del producto para buscar la información asociada, incluyendo
     * categorías, archivos de producto y precios. Si el producto no se encuentra,
     * se notifica al usuario y se redirige a la lista de productos.
     *
     * @param string|null $id El ID del producto que se desea mostrar.
     * @return \Cake\Http\Response|null|void Redirecciona a la lista de productos si el producto no existe o renderiza la vista con los detalles del producto.
     */
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

        $this->set('provincias', $this->Productos->DetallesPedidos->Pedidos->Direcciones->Localidades->Provincias->find('list')->where(['activo' => 1])->order('nombre')->all());
        $this->set(compact('producto'));
    }

    /**
     * Método add
     *
     * Este método permite la creación de un nuevo producto en el sistema. Al agregar un producto, se puede incluir información sobre
     * los precios asociados y subir imágenes del producto. Se asegura que la primera imagen subida se marque como la imagen principal.
     * En caso de errores durante el proceso de guardado, se notifica al usuario con mensajes informativos.
     *
     * @return \Cake\Http\Response|null|void Redirecciona a la lista de productos después de un guardado exitoso o renderiza la vista en caso contrario.
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
                $this->Flash->error(__('El producto no pudo ser guardado. Por favor, verifique los campos e intenete nuevamente.'));
                // if ($producto->getErrors()) {
                //     foreach ($producto->getErrors() as $field => $errors) {
                //         foreach ($errors as $error) {
                //             $this->Flash->error(__($error));
                //         }
                //     }
                // }
            }
        }
        $categorias = $this->Productos->Categorias->find('list')->where(['Categorias.activo' => 1])->all();
        $proveedores = $this->Productos->Proveedores->find('list')->where(['Proveedores.activo' => 1])->all();
        $this->set(compact('producto', 'categorias', 'proveedores'));
    }

    /**
     * Método edit
     *
     * Este método permite la edición de un producto existente. Al editar el producto, también se verifica si el precio ha cambiado,
     * y si es así, se actualiza el precio anterior con una `fecha_hasta` y se crea un nuevo registro de precio con la `fecha_desde`
     * actual. Los datos de precios son gestionados a través de la relación entre el producto y su entidad `ProductosPrecios`.
     *
     * @param string|null $id El ID del producto a editar. Si no se proporciona, será `null`.
     * @return \Cake\Http\Response|null|void Redirecciona después de una edición exitosa o renderiza la vista en caso contrario.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Si no se encuentra el registro del producto con el ID proporcionado.
     *
     * - Se consulta el producto por su ID, junto con sus archivos (`ProductosArchivos`) y precios (`ProductosPrecios`).
     * - Los precios se ordenan por `fecha_desde` de manera descendente para obtener el precio más reciente.
     * - Si el precio del producto ha cambiado, se actualiza el precio actual añadiendo la `fecha_hasta` y se crea un nuevo precio.
     * - En caso de error al guardar el nuevo precio, se muestra un mensaje de error utilizando el sistema de `Flash`.
     */
    public function edit($id = null)
    {
        try {
            $producto = $this->Productos->get($id, [
                'contain' => [
                    'ProductosArchivos',
                    'ProductosPrecios' => function ($q) {
                        return $q->order(['ProductosPrecios.fecha_desde' => 'DESC']);
                    }
                ]
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('El producto no existe.'));
            return $this->redirect(['action' => 'index']);
        } catch (\InvalidArgumentException $e) {
            $this->Flash->error('El producto no es válido.');
            return $this->redirect(['action' => 'index']);
        }



        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $guardarProducto = true; // Indicador para saber si guardar el producto o no

            // Verifica si hay un nuevo precio y si es diferente al actual
            if (isset($data['productos_precios'][0]['precio']) && $data['productos_precios'][0]['precio'] != $producto->productos_precios[0]->precio) {


                // Intenta guardar el precio existente con la fecha_hasta actualizada

                // Crea un nuevo precio
                $nuevoPrecio = $this->Productos->ProductosPrecios->newEntity([
                    'producto_id' => $producto->id,
                    'precio' => $data['productos_precios'][0]['precio'],
                    'fecha_desde' => date('Y-m-d H:i:s'),
                    'fecha_hasta' => null // Mantiene null hasta un cambio futuro
                ]);

                // Intenta guardar el nuevo precio
                if ($this->Productos->ProductosPrecios->save($nuevoPrecio)) {
                    $precioActual = $producto->productos_precios[0];
                    $precioActual->fecha_hasta = date('Y-m-d H:i:s');
                    $this->Productos->ProductosPrecios->save($precioActual);
                } else {
                    $guardarProducto = false;
                    $errors = $nuevoPrecio->getErrors();
                    $this->Flash->error(__('No se pudo guardar el nuevo precio.'));
                    if ($errors) {
                        foreach ($errors as $field => $fieldErrors) {
                            foreach ($fieldErrors as $error) {
                                $this->Flash->error(__($error));
                            }
                        }
                    }
                }
            }

            // Solo intenta guardar el producto si no hubo errores en la actualización del precio
            if ($guardarProducto) {
                unset($data['productos_precios']);
                $producto = $this->Productos->patchEntity($producto, $data);

                if ($this->Productos->save($producto)) {
                    $this->Flash->success(__('El producto se actualizó correctamente.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('El producto no pudo ser guardado. Por favor, verifique los campos e intenete nuevamente.'));
                }
            }
        }

        // Obtiene categorías y proveedores activos
        $categorias = $this->Productos->Categorias->find('list')->all();
        $proveedores = $this->Productos->Proveedores->find('list')->where(['Proveedores.activo' => 1])->all();
        $this->set(compact('producto', 'categorias', 'proveedores'));
    }

    /**
     * Método stock
     *
     * Este método maneja la solicitud para obtener el stock disponible de un producto específico.
     * Recibe como parámetro el ID del producto, busca el producto en la base de datos y devuelve
     * un objeto JSON que contiene el `id` del producto y su `stock`.
     *
     * @param int|null $id El ID del producto cuyo stock se desea consultar.
     * @return \Cake\Http\Response JSON con los datos del producto (id y stock).
     *
     * Ejemplo de respuesta JSON:
     * {
     *   "id": 34,
     *   "stock": 20
     * }
     *
     * - Se deshabilita el uso de layouts automáticos para este método, ya que solo se devuelve una respuesta JSON.
     * - Si no se encuentra un producto con el ID especificado, el resultado será `null` y se devolverá un JSON vacío.
     * - La respuesta es enviada con el tipo de contenido `application/json` para asegurar que sea interpretada correctamente.
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Si el producto con el ID proporcionado no existe.
     */
    public function stock($id = null)
    {
        $this->viewBuilder()->disableAutoLayout();

        $producto = $this->Productos->find()
            ->select(['id', 'stock']) // Selecciona solo los campos necesarios
            ->where(['id' => $id])
            ->first();
        $jsonData = json_encode($producto, JSON_PRETTY_PRINT);

        $response = new Response();
        $response = $response->withType('application/json')->withStringBody($jsonData);
        return $response;
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

    /**
     * Método categorias
     *
     * Este método permite obtener y mostrar los productos que pertenecen a una categoría específica.
     * Utiliza el ID de la categoría para buscar la información asociada, incluyendo productos y archivos de producto.
     * Si la categoría no se encuentra, se lanzará una excepción.
     *
     * @param string|null $id El ID de la categoría cuyos productos se desean mostrar.
     * @return \Cake\Http\Response|null|void Renderiza la vista con los productos de la categoría solicitada.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Cuando no se encuentra la categoría solicitada.
     */
    public function catalogoClienteCategorias($id = null)
    {
        try {
            $conditions = $this->getConditionsPublic();
            $categoria = $this->Productos->Categorias->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('La categoría no existe.'));
            return $this->redirect(['action' => 'index']);
        } catch (\InvalidArgumentException $e) {
            $this->Flash->error('La categoría no es válida.');
            return $this->redirect(['action' => 'index']);
        }

        $conditions['where'][] = ['categoria_id' => $id];

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
        $this->set('categoria', $categoria);
        $this->set('categoria_id', $id);
        $this->set('filters', $this->getRequest()->getQuery());
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
        try {
            $this->request->allowMethod(['post', 'delete']);
            $producto = $this->Productos->get($id);

            if ($this->Productos->delete($producto)) {
                $this->Flash->success(__('El producto ha sido eliminado.'));
                return $this->redirect(['action' => 'index']);
            } else {

                $this->Flash->error(__('No se pudo eliminar el producto. Por favor, inténtalo de nuevo.'));
            }
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('El producto no existe.'));
            return $this->redirect(['action' => 'index']);
        } catch (MethodNotAllowedException $e) {
            $this->Flash->error(__('Método HTTP no permitido.'));
            return $this->redirect(['action' => 'index']);
        } catch (\InvalidArgumentException $e) {
            $this->Flash->error('El producto no es válido.');
            return $this->redirect(['action' => 'index']);
        } catch (\Cake\Database\Exception\QueryException $e) {
            $this->Flash->error(__('El producto no puede ser eliminado porque esta asociado a uno o más pedidos.'));
            return $this->redirect('/Productos/index');
        } catch (\Exception $e) {
            $this->Flash->error(__('El producto no puede ser eliminado porque esta asociado a uno o más pedidos.'));
            return $this->redirect('/Productos/index');
        }


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

        if (!isset($data['search'])) {
            $data['search'] = '';
        }

        $orConditions = [];
        $orConditions[] = ['Productos.nombre LIKE' => '%' . $data['search'] . '%'];
        $orConditions[] = ['Productos.descripcion_breve LIKE ' => '%' . $data['search'] . '%'];
        $conditions['where']['OR'] = $orConditions;
        $conditions['where'][] = ['Categorias.activo' => 1];
        $conditions['where'][] = ['Productos.activo' => 1];

        return $conditions;
    }
}
