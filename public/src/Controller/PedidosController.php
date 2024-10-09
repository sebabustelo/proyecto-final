<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\DateTime;
use Cake\I18n\FrozenTime;

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
        // Obtener las condiciones
        $conditions = $this->getConditions();

        // Construir la consulta inicial con las condiciones 'where' y 'contain'
        $query = $this->Pedidos->find()
            ->where($conditions['where'])
            ->contain($conditions['contain']);

        // Verificar si existe el índice 'matching' en las condiciones
        if (!empty($conditions['matching'])) {
            foreach ($conditions['matching'] as $match) {
                // Aplicar el matching a la consulta
                $query = $query->matching($match[0], $match[1]);
            }
        }

        // Paginación y seteo de variables
        $this->set('filters', $this->getRequest()->getQuery());
        $this->set('pedidos', $this->paginate($query));
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
     * Edit method
     *
     * @param string|null $id Pedido id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // Cargar el pedido para obtener la fecha_pedido
        $pedido = $this->Pedidos->find()
            ->where(['Pedidos.id' => $id])
            ->contain(['PedidosEstados', 'DetallesPedidos' => [
                'Productos' => [
                    'ProductosPrecios' => function ($q) use ($id) {
                        // Obtener el pedido usando el ID
                        $pedido = $this->Pedidos->get($id);
                        return $q->where([
                            'fecha_desde <=' => $pedido->fecha_pedido,
                            'OR' => [
                                'fecha_hasta >=' => $pedido->fecha_pedido,
                                'fecha_hasta IS' => null // Considerar también precios sin fecha_hasta
                            ]
                        ]);
                    }
                ]
            ], 'OrdenesMedicas', 'RbacUsuarios' => ['TipoDocumentos']])
            ->first();

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
     * misPedidos method
     *
     * Este método obtiene los pedidos realizados por el cliente actual. Se utiliza
     * la sesión del usuario autenticado para filtrar los pedidos según el cliente
     * que los realizó. Los pedidos obtenidos son paginados por orden de fecha del pedido y enviados a la vista.
     *
     * Funcionalidad:
     * - Se establece una condición de búsqueda que incluye las relaciones con los
     *   estados del pedido (`PedidosEstados`), los detalles del pedido (`DetallesPedidos`),
     *   y dentro de los detalles, los productos asociados con sus archivos (`ProductosArchivos`).
     * - Se realiza una consulta para obtener los pedidos del cliente actual basándose
     *   en su `cliente_id` almacenado en la sesión.
     * - Se utiliza la paginación para mostrar los pedidos.
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function misPedidos()
    {
        $conditions['contain'] = [
            'PedidosEstados',
            'DetallesPedidos' => ['Productos' => ['ProductosArchivos']],
        ];

        $pedidos = $this->Pedidos->find()
            ->where(['cliente_id' => $_SESSION['RbacUsuario']['id']])
            ->contain($conditions['contain'])
            ->orderBy('fecha_pedido');

        $this->set('pedidos', $this->paginate($pedidos));
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



        if (isset($data['estado_id']) and !empty($data['estado_id'])) {
            $conditions['where'][] = ['Pedidos.estado_id' => $data['estado_id']];
        }


        if (isset($data['fecha_pedido']) && !empty($data['fecha_pedido'])) {
            // Separar las dos fechas basadas en el guion
            $fechas = explode(' - ', $data['fecha_pedido']);

            // Convertir las cadenas de fecha en objetos DateTime con hora de inicio y fin
            $fecha_inicio = DateTime::createFromFormat('d/m/Y H:i:s', $fechas[0] . ' 00:00:01');
            $fecha_fin = DateTime::createFromFormat('d/m/Y H:i:s', $fechas[1] . ' 23:59:59');

            // Verificar si las fechas fueron creadas correctamente
            if ($fecha_inicio && $fecha_fin) {
                // Agregar condiciones a la consulta
                $conditions['where'][] = ['Pedidos.fecha_pedido >= ' => $fecha_inicio->format('Y-m-d H:i:s')];
                $conditions['where'][] = ['Pedidos.fecha_pedido <= ' => $fecha_fin->format('Y-m-d H:i:s')];
            }
        }


        // Filtro por fecha_aplicacion (en DetallesPedidos)
        if (isset($data['fecha_aplicacion']) && !empty($data['fecha_aplicacion'])) {
            // Separar las dos fechas basadas en el guion
            $fechas = explode(' - ', $data['fecha_aplicacion']);

            // Convertir las cadenas de fecha en objetos DateTime con hora de inicio y fin
            $fecha_inicio = DateTime::createFromFormat('d/m/Y H:i:s', $fechas[0] . ' 00:00:01');
            $fecha_fin = DateTime::createFromFormat('d/m/Y H:i:s', $fechas[1] . ' 23:59:59');

            // Verificar si las fechas fueron creadas correctamente
            if ($fecha_inicio && $fecha_fin) {
                // Agregar condiciones utilizando matching correctamente
                $conditions['matching'][] = [
                    'DetallesPedidos',
                    function ($q) use ($fecha_inicio, $fecha_fin) {
                        return $q->where([
                            'DetallesPedidos.fecha_aplicacion >=' => $fecha_inicio->format('Y-m-d H:i:s'),
                            'DetallesPedidos.fecha_aplicacion <=' => $fecha_fin->format('Y-m-d H:i:s')
                        ]);
                    }
                ];
            }
        }





        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());

        return $conditions;
    }
}
