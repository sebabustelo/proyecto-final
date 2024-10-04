<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductosPreciosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductosPreciosTable Test Case
 */
class ProductosPreciosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductosPreciosTable
     */
    protected $ProductosPrecios;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ProductosPrecios',
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
        $config = $this->getTableLocator()->exists('ProductosPrecios') ? [] : ['className' => ProductosPreciosTable::class];
        $this->ProductosPrecios = $this->getTableLocator()->get('ProductosPrecios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ProductosPrecios);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ProductosPreciosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ProductosPreciosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
