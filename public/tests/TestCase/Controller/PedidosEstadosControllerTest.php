<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PedidosEstadosController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\PedidosEstadosController Test Case
 *
 * @uses \App\Controller\PedidosEstadosController
 */
class PedidosEstadosControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.PedidosEstados',
        'app.Pedidos',
        'app.RbacUsuarios'
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->initializeSession();
    }

    /**
     * Configura la sesión inicial para pruebas con datos de un usuario simulado
     */
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
                'PedidosEstados' => [
                    'index' => 1,
                    'add' => 1,
                    'view' => 1,
                    'delete' => 1,
                ],
            ],
        ]);
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\PedidosEstadosController::index()
     */
    public function testIndex(): void
    {
        $this->get('/PedidosEstados');

        $this->assertResponseOk();
        $filters = $this->viewVariable('filters');
        $this->assertNotNull($filters, 'Los filtros no fueron cargados correctamente.');
        $consultas = $this->viewVariable('estados');
        $this->assertNotEmpty($consultas, 'No se cargaron consultas en la vista.');
    }


    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PedidosEstadosController::add()
     */
    public function testAdd(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post('/PedidosEstados/add',  [
            'nombre' => 'estado nuevo',
            'descripcion' => 'descripcion nuevo estado',
            'activo' => 1,
            'orden' => 10,
        ]);

        $this->assertResponseSuccess();

        // Verifica que el nuevo estado se ha agregado a la base de datos
        $pedidosEstados = $this->getTableLocator()->get('PedidosEstados')->find()->all();

        // Verifica que el nuevo estado se haya guardado correctamente
        $nuevoPedidoEstado = $pedidosEstados->last();
        $this->assertEquals('ESTADO NUEVO', $nuevoPedidoEstado->nombre);
    }

    public function testAddFailure()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post('/PedidosEstados/add',  [
            'nombre' => '',
            'descripcion' => 'descripcion nuevo estado',
            'activo' => 1,
            'orden' => 10,
        ]);

        $this->assertResponseSuccess();

        // Verificamos que no se haya guardado ningun estado
        $tipoDocumentos = $this->getTableLocator()->get('PedidosEstados');
        $tipoDocumento = $tipoDocumentos->find()->where(['descripcion' => ''])->first();
        $this->assertEmpty($tipoDocumento);
    }


    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PedidosEstadosController::edit()
     */
    public function testEdit(): void
    {
        // ID de un estado existente
        $pedidosEstadosId = 1;

        $data =  [
            'nombre' => 'NUEVO',
            'descripcion' => 'Nuevo',
            'activo' => 1,
            'orden' => 10,
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/PedidosEstados/edit/{$pedidosEstadosId}", $data);
        $this->assertResponseCode(302);

        // Carga el estado de la base de datos y verifica los cambios
        $pedidosEstados = $this->getTableLocator()->get('PedidosEstados');
        $pedidosEstado = $pedidosEstados->get($pedidosEstadosId);

        $this->assertEquals('NUEVO', $pedidosEstado->nombre);
    }

    /**
     * Test testEditFailure method
     *
     * Prueba el método edit para manejar fallos al editar un tipo de documento con una descripción vacía
     * @return void
     * @uses \App\Controller\TipoDocumentosController::edit()
     */
    public function testEditFailure()
    {
        // ID de un tipo de documento existente
        $tipoDocumentoId = 1;

        $data =  [
            'id'=>'1',
            'nombre' => '',
            'descripcion' => 'Nuevo',
            'activo' => 1,
            'orden' => 10,
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post("/PedidosEstados/edit/{$tipoDocumentoId}", $data);
        $this->assertResponseSuccess();

        // Verificamos que no se haya guardado ningun tipo de documento
        $pedidosEstados = $this->getTableLocator()->get('PedidosEstados');
        $pedidosEstado = $pedidosEstados->find()->where(['descripcion' => ''])->first();
        $this->assertEmpty($pedidosEstado);
    }

    public function testEditNotExist(): void
    {
        $pedidosEstadosId = 999;

        $data =  [
            'id'=>'999',
            'nombre' => 'NUEVO',
            'descripcion' => 'Nuevo',
            'activo' => 1,
            'orden' => 10,
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/PedidosEstados/edit/{$pedidosEstadosId}", $data);
        $this->assertResponseCode(302);
    }

    public function testEditBadArgument(): void
    {
        //tipo de documento no válida
        $this->get('/PedidosEstados/edit/test');
        $this->assertResponseCode(302);
        $this->assertFlashMessage('El estado no es válido.');
    }

    public function testEditEmptyArgument(): void
    {
        //tipo de documento no válida
        $this->get('/PedidosEstados/edit/');
        $this->assertResponseCode(302);
        $this->assertFlashMessage('El estado no es válido.');
    }


    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\PedidosEstadosController::delete()
     */
    public function testDelete(): void
    {
        $pedidosEstadosId = 2;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/PedidosEstados/delete/{$pedidosEstadosId}");

        // Verifica que hubo una redirección después de eliminar
        $this->assertResponseCode(302);

        // Carga el tipo de documento desde la base de datos para verificar que se ha eliminado
        $pedidosEstados = $this->getTableLocator()->get('PedidosEstados');
        $pedidosEstado = $pedidosEstados->find()->where(['id' => $pedidosEstadosId])->first();

        $this->assertNull($pedidosEstado, 'El tipo de documento fue eliminado correctamente.');
    }

    public function testDeleteWithAssociatedPedidos(): void
    {
        $pedidosEstadosId = 3;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/PedidosEstados/delete/{$pedidosEstadosId}");

        $this->assertResponseCode(302);

        $this->assertSession('No se pudo eliminar el estado.', 'Flash.flash.0.message');
    }

    public function testDeleteEmpty(): void
    {
        $pedidosEstadosId = '';

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/PedidosEstados/delete/{$pedidosEstadosId}");

        // Verifica que hubo una redirección después de eliminar
        $this->assertResponseCode(302);
        $this->assertSession('El estado no es válido.', 'Flash.flash.0.message');
    }

    public function testDeleteMethodNotAllowed(): void
    {
        $pedidosEstadosId = 1;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->get("/PedidosEstados/delete/{$pedidosEstadosId}");

        $this->assertResponseCode(302);
        $this->assertSession('Método HTTP no permitido.', 'Flash.flash.0.message');
    }

    public function testDeleteBadArgument(): void
    {
        $pedidosEstadosId = "estado-no-valido";

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/PedidosEstados/delete/{$pedidosEstadosId}");
        $this->assertResponseCode(302);
        $this->assertFlashMessage('El estado no es válido.');
    }

    public function testDeleteNotExist(): void
    {
        $pedidosEstadosId = 99;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/PedidosEstados/delete/{$pedidosEstadosId}");

        $this->assertResponseCode(302);
        $this->assertSession('El estado no existe.', 'Flash.flash.0.message');
    }

    public function testGetConditions()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();;

        $this->get('/PedidosEstados/index?nombre=ejemplo&activo=1');
        $this->assertResponseOk();

        // Acceder a la variable set en la respuesta
        $data =  $this->_controller->getRequest()->getQuery();

        if (isset($data['nombre']) and !empty($data['nombre'])) {
            $conditions['where'][] = ['PedidosEstados.nombre LIKE' => '%' . $data['nombre'] . '%'];
        }

        if (isset($data['activo']) and !empty($data['activo'])) {
            $conditions['where'][] = ['PedidosEstados.activo' => $data['activo']];
        }

        // Verifica las condiciones
        $this->assertEquals([
            'where' => [
                ['PedidosEstados.nombre LIKE' => '%ejemplo%'],
                ['PedidosEstados.activo' => '1']
            ]
        ], $conditions);
    }
}
