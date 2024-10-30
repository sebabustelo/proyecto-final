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

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PedidosEstadosController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\PedidosEstadosController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
