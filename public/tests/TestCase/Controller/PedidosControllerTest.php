<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PedidosController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

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
        'app.TipoDocumentos'
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
    public function testAddForCliente(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

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
     * Test payment method
     *
     * @return void
     * @uses \App\Controller\PedidosController::payment()
     */
    public function testPayment(): void
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
        $this->markTestIncomplete('Not implemented yet.');
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
}
