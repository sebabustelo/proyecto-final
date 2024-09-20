<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsultasEstadosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConsultasEstadosTable Test Case
 */
class ConsultasEstadosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ConsultasEstadosTable
     */
    protected $ConsultasEstados;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ConsultasEstados',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ConsultasEstados') ? [] : ['className' => ConsultasEstadosTable::class];
        $this->ConsultasEstados = $this->getTableLocator()->get('ConsultasEstados', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ConsultasEstados);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ConsultasEstadosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ConsultasEstadosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
