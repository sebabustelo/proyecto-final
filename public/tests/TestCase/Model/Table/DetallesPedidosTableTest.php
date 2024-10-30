<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DetallesPedidosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DetallesPedidosTable Test Case
 */
class DetallesPedidosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DetallesPedidosTable
     */
    protected $DetallesPedidos;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.DetallesPedidos',
        'app.Pedidos',
        'app.Productos',
    ];

    /**
     * setUp method
     *
     * Configura el entorno de prueba antes de cada método de prueba.
     * Inicializa la instancia de DetallesPedidosTable.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DetallesPedidos') ? [] : ['className' => DetallesPedidosTable::class];
        $this->DetallesPedidos = $this->getTableLocator()->get('DetallesPedidos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->DetallesPedidos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DetallesPedidosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $detallePedido = $this->DetallesPedidos->newEntity([
            'pedido_id' => '',
            'producto_id' => 1,
            'cantidad' => 1,
        ]);

        $this->assertFalse($this->DetallesPedidos->save($detallePedido));
        $this->assertArrayHasKey('pedido_id', $detallePedido->getErrors());
        $this->assertSame('El campo pedido es obligatorio.', $detallePedido->getError('pedido_id')['_empty']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DetallesPedidosTable::buildRules()
     */
    public function testBuildRules()
    {
        // Obtén la instancia de la tabla
        $detallesPedidosTable = $this->getTableLocator()->get('DetallesPedidos');

        // Crea una nueva entidad con un pedido y un producto que existen
        $detallePedido = $detallesPedidosTable->newEntity([
            'pedido_id' => 1, // ID existente en fixture de Pedidos
            'producto_id' => 1, // ID existente en fixture de Productos
            'cantidad' => 2
        ]);
        $this->assertEmpty($detallePedido->getErrors(), 'No se deben producir errores si pedido_id y producto_id existen');

        // Intenta guardar la entidad y verifica que la operación es exitosa
        $result = $detallesPedidosTable->save($detallePedido);
        $this->assertNotEmpty($result, 'La entidad debería guardarse cuando pedido_id y producto_id existen');

        // Prueba con un pedido inexistente
        $detallePedido = $detallesPedidosTable->newEntity([
            'pedido_id' => 999, // ID inexistente
            'producto_id' => 1, // ID existente en fixture de Productos
            'cantidad' => 2
        ]);
        $this->assertFalse($detallesPedidosTable->save($detallePedido), 'La entidad no debería guardarse si pedido_id no existe');
        $this->assertArrayHasKey('pedido_id', $detallePedido->getErrors(), 'Debería haber un error en pedido_id');

        // Prueba con un producto inexistente
        $detallePedido = $detallesPedidosTable->newEntity([
            'pedido_id' => 1, // ID existente en fixture de Pedidos
            'producto_id' => 999, // ID inexistente
            'cantidad' => 2
        ]);
        $this->assertFalse($detallesPedidosTable->save($detallePedido), 'La entidad no debería guardarse si producto_id no existe');
        $this->assertArrayHasKey('producto_id', $detallePedido->getErrors(), 'Debería haber un error en producto_id');
    }
}
