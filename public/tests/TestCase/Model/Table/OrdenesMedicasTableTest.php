<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdenesMedicasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdenesMedicasTable Test Case
 */
class OrdenesMedicasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdenesMedicasTable
     */
    protected $OrdenesMedicas;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.OrdenesMedicas',
        'app.Pedidos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('OrdenesMedicas') ? [] : ['className' => OrdenesMedicasTable::class];
        $this->OrdenesMedicas = $this->getTableLocator()->get('OrdenesMedicas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->OrdenesMedicas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OrdenesMedicasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OrdenesMedicasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
