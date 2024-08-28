<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResolucionRelacionadasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResolucionRelacionadasTable Test Case
 */
class ResolucionRelacionadasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResolucionRelacionadasTable
     */
    protected $ResolucionRelacionadas;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ResolucionRelacionadas',
        'app.Resoluciones',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ResolucionRelacionadas') ? [] : ['className' => ResolucionRelacionadasTable::class];
        $this->ResolucionRelacionadas = $this->getTableLocator()->get('ResolucionRelacionadas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ResolucionRelacionadas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ResolucionRelacionadasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ResolucionRelacionadasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
