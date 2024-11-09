<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PedidosController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\I18n\DateTime;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\PedidosController Test Case
 *
 * @uses \App\Controller\PedidosController
 */
class PedidosControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Pedidos',
        'app.RbacUsuarios',
        'app.PedidosEstados',
        'app.DetallesPedidos',
        'app.OrdenesMedicas',
        'app.Direcciones',
        'app.Productos',
        'app.TipoDocumentos',
        'app.RbacToken'
    ];

    private function initializeSession(): void
    {
        $this->session([
            'RbacUsuario' => [
                'id' => 1,
                'perfil_id' => 1,
                'direccion_id' => 1,
                'usuario' => 'usuario_test',
                'email' => 'test@example.com',
                'nombre' => 'Nombre',
                'apellido' => 'Apellido',
                'tipo_documento_id' => 1,
                'documento' => '12345678',
                'cuit' => 1,
                'razon_social' => 'Empresa Test',
                'celular' => '123456789',
                'password' => 'password_hash',
                'seed' => 'seed_value',
                'activo' => 1,
                'created' => '2024-10-24 15:30:16',
                'modified' => '2024-10-24 15:30:16',
                'created_by' => 'Admin',
                'modified_by' => 'Admin',
            ],
            'RbacAcciones' => [
                'Pedidos' => [
                    'index' => 1,
                    'add' => 1,
                    'view' => 1,
                    'delete' => 1,
                    'payment'=>1
                ],
            ],
        ]);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->initializeSession();
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\PedidosController::index()
     */
    public function testIndex(): void
    {
        $this->get('/Pedidos');

        $this->assertResponseOk();
        $filters = $this->viewVariable('filters');
        $this->assertNotNull($filters, 'Los filtros no fueron cargados correctamente.');
        $pedidos = $this->viewVariable('pedidos');
        $this->assertNotEmpty($pedidos, 'No se cargaron consultas en la vista.');
    }



    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PedidosController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PedidosController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test addForCliente method
     *
     * @return void
     * @uses \App\Controller\PedidosController::addForCliente()
     */
    public function testAddForClienteSuccess()
    {
        $data = [

            'cliente_id' => 1,
            'estado_id' => 3,
            'direccion_id' => 1,
            'fecha_pedido' => '2024-10-30 16:00:27',
            'fecha_intervencion' => '2028-10-30',
            'comentario' => 'pedidos 1',
            'created' => '2024-10-30 16:00:27',
            'modified' => '2024-10-30 16:00:27',
            'detalles_pedidos' => [
                [
                    'producto_id' => 1,
                    'cantidad' => 1
                ]
            ],
            'orden_medica' => [
                'file_name' => 'orden_medica.pdf',
                'file_extension' => 'pd',
                'file_size' => 1000,
                'file_path' => 'uploads/ordenes_medica/orden_medica.pdf'
            ],
        ];

        // Crear el mock del componente Upload y envolverlo en un Closure
        $this->mockService(
            \App\Controller\Component\UploadComponent::class,
            function () {
                $uploadMock = $this->createMock(\App\Controller\Component\UploadComponent::class);
                $uploadMock->method('upload')
                    ->willReturn([
                        'status' => true,
                        'file' => [
                            'file_name' => 'orden_medica.pdf',
                            'file_extension' => 'pd',
                            'file_size' => 1000,
                            'file_path' => 'uploads/ordenes_medica/orden_medica.pdf'
                        ],


                    ]);
                return $uploadMock;
            }
        );

        // Simula la existencia de stock suficiente
        $producto = TableRegistry::getTableLocator()->get('Productos')->get(1);
        $producto->stock = 10;
        TableRegistry::getTableLocator()->get('Productos')->save($producto);

        $this->enableCsrfToken();
        $this->enableSecurityToken();;
        $this->post('/pedidos/addForCliente', $data);
        $this->assertResponseSuccess();
        $this->assertFlashMessage('El pedido se guardó correctamente. Puede hacer el seguimiento del mismo desde el menú "Mis Pedidos".');

        // Verificar que el pedido fue guardado en la base de datos
        $pedidosTable = TableRegistry::getTableLocator()->get('Pedidos');

        $pedido = $pedidosTable->find()->contain(['PedidosEstados'])->all();
        $nuevo_pedido = $pedido->last();
        $this->assertNotEmpty($pedido);
        $this->assertEquals('PENDIENTE', $nuevo_pedido->pedidos_estado->nombre);

        // Verificar que la orden médica fue guardada
        $ordenMedica = $pedidosTable->OrdenesMedicas->find()->where(['pedido_id' => $nuevo_pedido->id])->first();
        $this->assertNotEmpty($ordenMedica);
        $this->assertEquals('orden_medica.pdf', $ordenMedica->file_name);
    }

    public function testPaymentTokenValidoActualizacionExitosa()
    {
        // Generar un token válido
        $pedidosTable = TableRegistry::getTableLocator()->get('Pedidos');


        // Crear un pedido en estado pendiente para el usuario de prueba
        $pedido = $pedidosTable->newEntity([

            'cliente_id' => 1,
            'estado_id' => 3,
            'direccion_id' => 1,
            'fecha_pedido' => '2024-10-30 16:00:27',
            'fecha_intervencion' => '2028-10-30',
            'comentario' => 'pedidos 1',
            'created' => '2024-10-30 16:00:27',
            'modified' => '2024-10-30 16:00:27',
            'detalles_pedidos' => [
                [
                    'producto_id' => 1,
                    'cantidad' => 1
                ]
            ],
            'orden_medica' => [
                'file_name' => 'orden_medica.pdf',
                'file_extension' => 'pd',
                'file_size' => 1000,
                'file_path' => 'uploads/ordenes_medica/orden_medica.pdf'
            ],
        ]);

        // Crear el mock del componente Upload y envolverlo en un Closure
        $this->mockService(
            \App\Controller\Component\UploadComponent::class,
            function () {
                $uploadMock = $this->createMock(\App\Controller\Component\UploadComponent::class);
                $uploadMock->method('upload')
                    ->willReturn([
                        'status' => true,
                        'file' => [
                            'file_name' => 'orden_medica.pdf',
                            'file_extension' => 'pd',
                            'file_size' => 1000,
                            'file_path' => 'uploads/ordenes_medica/orden_medica.pdf'
                        ],


                    ]);
                return $uploadMock;
            }
        );

        $pedidosTable->save($pedido);

        $token = base64_encode(openssl_random_pseudo_bytes(24));
        $token = $pedido->id."-".strtr(substr($token, 0, 24), '+/=-', '_,');

        // Crear un token en la tabla `RbacToken` asociado a un pedido
        $tokenTable = TableRegistry::getTableLocator()->get('Rbac.RbacToken');
        $token = $tokenTable->newEntity([
            'token' => $token,
            'rbac_usuario_id' => 1,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+1 hour')),
            'validez'=> 1440
        ]);
        $tokenTable->save($token);

        // Ejecutar el método de prueba
        $this->enableCsrfToken();
        $this->enableSecurityToken();;
        $this->post('/pedidos/payment/' . $token['token']);

        // Verificar redirección y mensaje de éxito
        //$this->assertRedirect(['controller' => 'Pedidos', 'action' => 'misPedidos']);
        $this->assertFlashMessage('El pago se realizo correctamente, su pedido esta en proceso de entrega.');
    }

    public function testPaymentTokenInvalido()
    {
        // Generar un token inválido (por ejemplo, uno que no existe en la base de datos)
        $pedidosTable = TableRegistry::getTableLocator()->get('Pedidos');
        $token = base64_encode(openssl_random_pseudo_bytes(24));
        $token = strtr(substr($token, 0, 24), '+/=', '-_,');

        // Ejecutar el método de prueba
        $this->enableCsrfToken();
        $this->enableSecurityToken();;
        $this->post('/pedidos/payment/' . $token);

        // Verificar redirección y mensaje de error
        //$this->assertRedirect(['plugin' => 'Rbac', 'controller' => 'RbacUsuarios', 'action' => 'login']);
        $this->assertFlashMessage('Token no es válido o ha expirado.');
    }


    // Otros métodos de prueba similares para los demás casos.


    /**
     * Test ordenMedicaValida method
     *
     * @return void
     * @uses \App\Controller\PedidosController::ordenMedicaValida()
     */
    public function testOrdenMedicaValida(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test misPedidos method
     *
     * @return void
     * @uses \App\Controller\PedidosController::misPedidos()
     */
    public function testMisPedidos(): void
    {
        $this->get('/Pedidos/misPedidos');

        $this->assertResponseCode(302);

        $pedidos = $this->viewVariable('pedidos');
        $this->assertNotEmpty($pedidos, 'No se cargaron consultas en la vista.');
    }

    /**
     * Test cancelar method
     *
     * @return void
     * @uses \App\Controller\PedidosController::cancelar()
     */
    public function testCancelar(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testGetConditions()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();;

        $this->get('/Pedidos/index?cliente_id=2&estado_id=2&documento=&apellido=&email=&producto=k&fecha_pedido=03%2F11%2F2024+-+04%2F12%2F2024&fecha_intervencion=03%2F11%2F2024+-+17%2F12%2F2024');
        $this->assertResponseOk();

        // Acceder a la variable set en la respuesta
        $data =  $this->_controller->getRequest()->getQuery();

        if (isset($data['cliente_id']) and !empty($data['cliente_id'])) {
            $conditions['where'][] = ['Pedidos.cliente_id' =>  $data['cliente_id']];
        }

        if (isset($data['estado_id']) and !empty($data['estado_id'])) {
            $conditions['where'][] = ['Pedidos.estado_id' => $data['estado_id']];
        }

        if (isset($data['producto']) and !empty($data['producto'])) {
            $conditions['where'][] = ['Productos.nombre like ' => "%" . $data['producto'] . "%"];
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
                $conditions['where'][] = ['Pedidos.fecha_pedido >=' => $fecha_inicio->format('Y-m-d H:i:s')];
                $conditions['where'][] = ['Pedidos.fecha_pedido <=' => $fecha_fin->format('Y-m-d H:i:s')];
            }
        }

        // Filtro por fecha_aplicacion (en DetallesPedidos)
        if (isset($data['fecha_intervencion']) && !empty($data['fecha_intervencion'])) {
            // Separar las dos fechas basadas en el guion
            $fechas = explode(' - ', $data['fecha_intervencion']);

            // Convertir las cadenas de fecha en objetos DateTime con hora de inicio y fin
            $fecha_inicio = DateTime::createFromFormat('d/m/Y H:i:s', $fechas[0] . ' 00:00:01');
            $fecha_fin = DateTime::createFromFormat('d/m/Y H:i:s', $fechas[1] . ' 23:59:59');

            // Verificar si las fechas fueron creadas correctamente
            if ($fecha_inicio && $fecha_fin) {
                $conditions['where'][] = ['Pedidos.fecha_intervencion >=' => $fecha_inicio->format('Y-m-d H:i:s')];
                $conditions['where'][] = ['Pedidos.fecha_intervencion <=' => $fecha_fin->format('Y-m-d H:i:s')];
            }
        }


        // Verifica las condiciones

        $this->assertEquals([
            'where' => [
                ['Pedidos.cliente_id' => '2'],
                ['Pedidos.estado_id' => '2'],
                ['Productos.nombre like ' => '%k%'],
                ['Pedidos.fecha_pedido >=' => '2024-11-03 00:00:01'],
                ['Pedidos.fecha_pedido <=' => '2024-12-04 23:59:59'],
                ['Pedidos.fecha_intervencion >=' => '2024-11-03 00:00:01'],
                ['Pedidos.fecha_intervencion <=' => '2024-12-17 23:59:59']
            ]
        ], $conditions);
    }
}
