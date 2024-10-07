<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Categorias Controller
 *
 * @property \App\Model\Table\CategoriasTable $Categorias
 */
class PedidosController extends AppController
{

    protected array $paginate = [
        'limit' => 10,
        'order' => [
            'Proveedores.nombre' => 'asc',
        ],
    ];

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
        $pedidos = $this->Pedidos->find()
            ->where($conditions['where'])
            ->contain($conditions['contain']);

        $this->set('filters', $this->getRequest()->getQuery());
        $this->set('pedidos', $this->paginate($pedidos));
        $this->set('estados', $this->Pedidos->PedidosEstados->find('list')->orderBy('orden')->all());
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pedidos = $this->Pedidos->newEmptyEntity();
        if ($this->request->is('post')) {
            $proveedore = $this->Pedidos->patchEntity($pedidos, $this->request->getData());
            if ($this->Pedidos->save($pedidos)) {
                $this->Flash->success(__('El pedido se guardo correctamente.'));

                return $this->redirect('/Pedidos/index');;
            }
            $this->Flash->error(__('El pedido no pudo ser guardada. Por favor, verifique los campos e intenete nuevamente.'));
        }
        $this->set(compact('pedido'));
    }

    /**
     * addForCliente Método para agregar un nuevo pedido realizado por el cliente.
     *
     * Este método crea un nuevo pedido para un cliente autenticado. El pedido
     * se inicializa en estado 'PENDIENTE' y se asocian los detalles del pedido,
     * órdenes médicas y el estado del pedido. Si el pedido se guarda correctamente,
     * se muestra un mensaje de éxito y se redirige a la página de detalles del producto.
     * En caso de error, se muestran mensajes de validación.
     *
     * @return \Cake\Http\Response|null|void Redirige en caso de éxito, o renderiza la vista en caso de error.
     */
    public function addForCliente()
    {
        if ($this->request->is('post')) {
            $pedido = $this->Pedidos->newEmptyEntity();

            // Iniciar la transacción
            $connection = $this->Pedidos->getConnection();
            $connection->begin();

            try {

                $pedido = $this->Pedidos->patchEntity(
                    $pedido,
                    $this->request->getData(),
                    [
                        'associated' => [
                            'DetallesPedidos' => ['Productos'],
                            'OrdenesMedicas',
                            'PedidosEstados'
                        ],
                    ]
                );

                // Obtener estado PENDIENTE
                $estadoPendiente = $this->Pedidos->PedidosEstados
                    ->find()
                    ->where(['nombre' => 'PENDIENTE'])
                    ->first();

                // Asignar valores adicionales al pedido
                $pedido['estado_id'] = $estadoPendiente->id;
                $pedido['cliente_id'] = $_SESSION['RbacUsuario']['id'];
                $pedido['fecha_pedido'] = date('Y-m-d H:i:s');

                // Guardar el pedido
                if ($this->Pedidos->save($pedido)) {

                    // Reducción del stock del producto
                    $producto_id = $pedido->detalles_pedidos[0]->producto_id;
                    $producto = $this->Pedidos->DetallesPedidos->Productos->find()->where(['id' => $producto_id])->first();
                    if ($producto) {
                        $producto->stock = $producto->stock - 1;
                        $this->Pedidos->DetallesPedidos->Productos->save($producto);
                    }

                    // Subida de la orden médica
                    $file = $this->request->getData('orden_medica');
                    $result = $this->Upload->upload($file, WWW_ROOT . 'uploads/ordenes_medicas/');

                    if ($result['status']) {
                        $orden_medica = $this->Pedidos->OrdenesMedicas->newEmptyEntity();
                        $orden_medica->pedido_id = $pedido->id;
                        $orden_medica->file_name = $result['file']['file_name'];
                        $orden_medica->file_extension = $result['file']['file_extension'];
                        $orden_medica->file_size = $result['file']['file_size'];
                        $orden_medica->file_path = $result['file']['file_path'];

                        // Guardar la orden médica
                        if (!$this->Pedidos->OrdenesMedicas->save($orden_medica)) {
                            throw new \Exception('Error al guardar la orden médica.');
                        }

                        // Confirmar la transacción
                        $connection->commit();

                        $this->Flash->success(__('El pedido se guardó correctamente. Puede hacer el seguimiento del mismo desde el menú "Mis Pedidos".'));
                    } else {
                        $this->Flash->error(__('Ocurrio un error al guardar ' . $result['error']));
                        //throw new \Exception($result['error']); // Lanzar una excepción si hay un error al subir la orden médica
                    }
                } else {
                    $this->Flash->error(__('Ocurrio un error al guardar el pedido'));
                    //throw new \Exception('Error al guardar el pedido.');
                }
            } catch (\Exception $e) {
                // En caso de error, hacer rollback de la transacción
                $connection->rollback();
                $this->Flash->error($e->getMessage());
            }
            return $this->redirect('/Productos/detail/' . $pedido->detalles_pedidos[0]->producto_id);
            $this->set(compact('pedido'));
        }
    }


    /**
     * Edit method
     *
     * @param string|null $id Pedido id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pedido = $this->Pedidos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pedido = $this->Pedidos->patchEntity($pedido, $this->request->getData());
            if ($this->Pedidos->save($pedido)) {
                $this->Flash->success(__('El proveedor se actualizo correctamente.'));

                return $this->redirect('/Pedidos/index');;
            }
            $this->Flash->error(__('El pedido no pudo ser guardada. Por favor, verifique los campos e intenete nuevamente.'));
        }
        $this->set(compact('pedido'));
    }

    /**
     * misPedidos method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function misPedidos()
    {
        // $conditions = $this->getConditions();
        // $categorias = $this->Categorias->find()
        //     ->where($conditions['where'])
        //     ->contain($conditions['contain']);

        // $this->set('filters', $this->getRequest()->getQuery());
        // $this->set('categorias', $this->paginate($categorias));
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
        $conditions['contain'] = [
            'PedidosEstados',
            'DetallesPedidos' => ['Productos'],
            'OrdenesMedicas',
            'PedidosEstados',
            'RbacUsuarios' => ['TipoDocumentos']
        ];

        if (isset($data['cliente_id']) and !empty($data['cliente_id'])) {
            $conditions['where'][] = ['Pedidos.cliente_id' =>  $data['cliente_id']];
        }

        // if (isset($data['fecha_pedido']) and !empty($data['fecha_pedido'])) {
        //     $conditions['where'][] = ['Categorias.fecha_pedido LIKE ' => '%' . $data['descripcion'] . '%'];
        // }

        if (isset($data['estado_id']) and !empty($data['cliente_id'])) {
            $conditions['where'][] = ['Pedidos.estado_id' => $data['estado_id']];
        }

        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());

        return $conditions;
    }
}
