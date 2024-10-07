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
     * @var array<string>
     */
    protected array $fixtures = [
        'app.DetallesPedidos',
        'app.Pedidos',
        'app.Productos',
    ];

    /**
     * setUp method
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
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DetallesPedidosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
