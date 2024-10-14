<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\DateTime;
use Cake\Routing\Router;
use Cake\Mailer\Mailer;
use Cake\Mailer\Exception\MissingActionException;
use Cake\Http\Exception\InvalidCsrfTokenException;

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
            'Pedidos.fecha_pedido' => 'asc',
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
            ->contain(['PedidosEstados', 'OrdenesMedicas', 'DetallesPedidos' => [
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
                $this->Flash->success(__('El pedido se actualizo correctamente.'));

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
                            'PedidosEstados',
                            'Direcciones'
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

                // Verificar stock
                $producto_id = $pedido->detalles_pedidos[0]->producto_id;
                $producto = $this->Pedidos->DetallesPedidos->Productos->find()->where(['id' => $producto_id])->first();

                if ($producto->stock >= ($this->request->getData('detalles_pedidos')[0]['cantidad'])) {
                    $producto->stock = $producto->stock - 1;
                    $this->Pedidos->DetallesPedidos->Productos->save($producto);
                } else {
                    //$this->Flash->error(__('Lo sentimos, el producto que solicitaste se ha agotado. Por favor, verifica más tarde o elige otro producto.'));
                    throw new \Exception('Lo sentimos, el producto que solicitaste se ha agotado. Por favor, verifica más tarde o elige otro producto.');
                }

                // Guardar el pedido
                if ($this->Pedidos->save($pedido)) {

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
                        $connection->rollback();
                        //$this->Flash->error(__('Ocurrio un error al guardar ' . $result['error']));
                        $this->Flash->error(__('Ocurrio un error al guardar la orden médica'));
                        //throw new \Exception($result['error']); // Lanzar una excepción si hay un error al subir la orden médica
                    }
                } else {
                    $this->Flash->error(__('Ocurrio un error al guardar el pedido'));
                    //throw new \Exception('Error al guardar el pedido.');
                }
            } catch (\Exception $e) {
                // En caso de error, hacer rollback de la transacción
                $connection->rollback();
                // $this->Flash->error(__('Ocurrio un error al guardar el pedido'));
                $this->Flash->error($e->getMessage());
            }
            return $this->redirect('/Productos/catalogoCliente');
            $this->set(compact('pedido'));
        }
    }

    /**
     * Valida y actualiza el estado de un pedido médico.
     *
     * Este método busca un pedido en la base de datos por su ID y verifica si su estado
     * actual es 'PENDIENTE'. Si es así, cambia el estado a 'EN_PROCESO' y guarda los
     * cambios. Si el estado no es 'PENDIENTE', se muestra un mensaje de error.
     *
     * @param int $id ID del pedido a validar y actualizar.
     * @return \Cake\Http\Response|null Redirige a la página de listado de pedidos
     *                                    después de una actualización exitosa o un error.
     */
    public function ordenMedicaValida($id)
    {
        $pedido = $this->Pedidos->find()
            ->where(['Pedidos.id' => $id])
            ->contain(['PedidosEstados', 'DetallesPedidos' => ['Productos'], 'RbacUsuarios'])
            ->first();

        //debug($pedido);die;

        if ($this->request->is(['patch', 'post', 'put'])) {

            if ($pedido->pedidos_estado->nombre == 'PENDIENTE') {
                $estado_en_proceso = $this->Pedidos->PedidosEstados->find()->where(['PedidosEstados.nombre' => 'EN_PROCESO'])->first();
                $pedido->estado_id = $estado_en_proceso->id;
                $pedido->pedidos_estado = $estado_en_proceso;

                if ($this->Pedidos->save($pedido)) {

                    $token                           = $id . "-" . $this->generateToken();
                    $rbacTokenTable = $this->fetchTable('Rbac.RbacToken');
                    $data['token']      = $token;
                    $data['rbac_usuario_id'] = $pedido->cliente->id;
                    $data['validez']    = 1440;
                    $rbacToken = $rbacTokenTable->newEntity($data);

                    $datos               = array();
                    $datos['subject']    = 'Link de pago del producto: ' . $pedido->detalles_pedidos[0]->producto->nombre;
                    $datos['url']        = Router::url('/', true) . "Pedidos/payment/" . $token;
                    $datos['aplicacion'] = "IPMAGNA";
                    $datos['template']   = 'payment';
                    $datos['email']      = $pedido->cliente->email;

                    // debug($datos);die;

                    if ($rbacTokenTable->save($rbacToken)) {
                        if ($this->sendEmail($datos)) {
                            $this->Flash->success('Se ha enviado la información a ' . $pedido->cliente->email . ' para realizar el pago del pedido.');
                        } else {
                            throw new \Exception('No se pudo enviar el email pago al cliente.');
                        }
                    } else {
                        throw new \Exception('No se pudo generar el token para el pago que se envia por email.');
                    }

                    //$this->Flash->success(__('El pedido se actualizo correctamente.'));

                    return $this->redirect('/Pedidos/index');
                }
            } else {
                $this->Flash->error(__('El estado del pedido no es PENDIENTE, acción no válida.'));
                return $this->redirect('/Pedidos/index');
            }
            $this->Flash->error(__('El pedido no pudo ser guardada. Por favor, verifique los campos e intenete nuevamente.'));
        }
        $this->set(compact('pedido'));
    }

    public function payment($token)
    {

        $this->RbacToken = $this->fetchTable('Rbac.RbacToken');
        $resultToken = $this->RbacToken->find()->where(['token' => $token])->contain(['RbacUsuarios'])->first();
        // debug($resultToken);
        // die;

        if (!$resultToken || !$this->RbacToken->isValidToken($token)) {
            $this->Flash->error('Token no es válido o ha expirado.');
            return $this->redirect(['plugin' => 'Rbac', 'controller' => 'RbacUsuarios', 'action' => 'login']);
        }

        $partes = explode('-', $resultToken->token);

        // Obtener el primer valor antes del guion
        $pedido_id = $partes[0];

        // Cargar el pedido para obtener la fecha_pedido
        $pedido = $this->Pedidos->find()
            ->where(['Pedidos.id' => $pedido_id])
            ->contain(['PedidosEstados', 'DetallesPedidos' => [
                'Productos' => [
                    'ProductosPrecios' => function ($q) use ($pedido_id) {
                        // Obtener el pedido usando el ID
                        $pedido = $this->Pedidos->get($pedido_id);
                        return $q->where([
                            'fecha_desde <=' => $pedido->fecha_pedido,
                            'OR' => [
                                'fecha_hasta >=' => $pedido->fecha_pedido,
                                'fecha_hasta IS' => null // Considerar también precios sin fecha_hasta
                            ]
                        ]);
                    }
                ]
            ], 'RbacUsuarios' => ['TipoDocumentos']])
            ->first();


        // Obtener estado PENDIENTE
        $estadoPagado = $this->Pedidos->PedidosEstados
            ->find()
            ->where(['nombre' => 'PAGADO'])
            ->first();

        // Asignar valores adicionales al pedido
        $pedido['estado_id'] = $estadoPagado->id;

        if ($this->Pedidos->save($pedido)) {

            if ($this->RbacToken->delete($resultToken)) {

                $this->Flash->success('El pago se realizo correctamente, su pedido esta en proceso de entrega.');
                return $this->redirect(['controller' => 'Pedidos', 'action' => 'misPedidos']);
            } else {
                throw new \Exception('No se pudo eliminar el token.');
            }
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
     * Genera condiciones de búsqueda basadas en los parámetros de consulta de la solicitud.
     *
     * Este método construye un arreglo de condiciones para filtrar los resultados
     * de búsqueda en el contexto de pedidos. Recupera los parámetros de consulta
     * de la solicitud, procesa rangos de fechas y construye las condiciones
     * necesarias para filtrar los `Pedidos` junto con las entidades relacionadas.
     *
     * @param string|null $data Datos enviados por el formulario en la cadena de consulta. Si no se proporcionan datos, el método seguirá devolviendo un arreglo de condiciones vacío.
     * @return array $conditions Un arreglo que contiene:
     *     - 'where': Condiciones para filtrar resultados basados en campos específicos.
     *     - 'contain': Asociaciones que se incluirán en los resultados de la consulta, tales como
     *       'PedidosEstados', 'DetallesPedidos' (con 'Productos'),
     *       'OrdenesMedicas', y 'RbacUsuarios' (con 'TipoDocumentos').
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Cuando no se encuentra un registro solicitado.
     *
     * El método también almacena la URL anterior en la sesión para su referencia posterior.
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
                $conditions['where'][] = ['Pedidos.fecha_aplicacion >= ' => $fecha_inicio->format('Y-m-d H:i:s')];
                $conditions['where'][] = ['Pedidos.fecha_aplicacion <= ' => $fecha_fin->format('Y-m-d H:i:s')];
            }
        }

        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());

        return $conditions;
    }

    private function generateToken($length = 24)
    {
        if (function_exists('openssl_random_pseudo_bytes')) {
            $token = base64_encode(openssl_random_pseudo_bytes($length, $strong));
            if ($strong == TRUE) {
                return strtr(substr($token, 0, $length), '+/=', '-_,');
            }
        }

        //php < 5.3 or no openssl
        $characters = '0123456789';
        $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz+';
        $charactersLength = strlen($characters) - 1;
        $token            = '';

        //select some random characters
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[mt_rand(0, $charactersLength)];
        }

        return $token;
    }

    private function sendEmail($datos)
    {
        $mailer = new Mailer('default');
        try {
            $mailer->setFrom(['ipmagna-noreply@gmail.com' => 'IPMAGNA'])
                ->setTo($datos['email'])
                ->setSubject($datos['subject'])
                ->setEmailFormat('html')
                ->setViewVars(['url' => @$datos['url']])
                ->viewBuilder()
                ->setTemplate($datos['template'])
                ->setPlugin('Rbac');

            $mailer->deliver();

            return true;
        } catch (MissingActionException $e) {
            $this->Flash->error('Error en el envío: ' . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            $this->Flash->error('Se produjo un error inesperado: ' . $e->getMessage());
            return false;
        }
    }
}
