<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PedidosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PedidosTable Test Case
 */
class PedidosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PedidosTable
     */
    protected $Pedidos;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Pedidos',
        //'plugin.Rbac.RbacUsuarios',
        'app.PedidosEstados',
        'app.DetallesPedidos',
        'app.OrdenesMedicas',
        'app.Direcciones',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Pedidos') ? [] : ['className' => PedidosTable::class];
        $this->Pedidos = $this->getTableLocator()->get('Pedidos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Pedidos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PedidosTable::validationDefault()
     */
    public function testBuildRules(): void
    {
        // Crear un nuevo pedido con un cliente inexistente
        $pedido = $this->Pedidos->newEntity([
            'cliente_id' => null, // ID de cliente inexistente
            'estado_id' => 1,
            'direccion_id' => 1,
            'nombre' => 'Pedido de prueba',
            'fecha_pedido' => '2024-10-17 15:44:46',
            'fecha_aplicacion' => '2024-10-25',
        ]);

        // Guardar el pedido debería fallar por la regla de negocio
        $result = $this->Pedidos->save($pedido);


        // Verificar que el pedido no fue guardado
        $this->assertFalse($result, 'El pedido fue guardado, pero debería haber fallado por la regla de negocio.');

        // Revisar si la entidad tiene errores
        $errors = $pedido->getErrors();

        // Si hay errores, asegurarnos de que estén relacionados con la regla de negocio de 'cliente_id'
       // $this->assertNotEmpty($errors, 'No se encontraron errores en la entidad.');
        $this->assertArrayHasKey('cliente_id', $errors, 'El error debería estar relacionado con cliente_id.');
    }
    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PedidosTable::buildRules()
     */
    // public function testBuildRules(): void
    // {
    //     // Crear un nuevo pedido con un usuario no existente
    //     $pedido = $this->Pedidos->newEntity([
    //         'usuario_id' => 99999, // ID de usuario inexistente
    //         'nombre' => 'Pedido de prueba',
    //     ]);

    //     // Guardar el pedido debería fallar por la regla de negocio
    //     $result = $this->Pedidos->save($pedido);

    //     // Verificar que el pedido no fue guardado
    //     $this->assertFalse($result, 'El pedido fue guardado, pero debería haber fallado por regla de negocio.');

    //     // Revisar si la entidad tiene errores
    //     $errors = $pedido->getErrors();

    //     // Si hay errores, asegurarnos de que estén relacionados con la regla de negocio de 'usuario_id'
    //     $this->assertNotEmpty($errors, 'No se encontraron errores en la entidad.');
    // }

}
