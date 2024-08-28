<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResolucionesAreasConocimientoTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResolucionesAreasConocimientoTable Test Case
 */
class ResolucionesAreasConocimientoTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResolucionesAreasConocimientoTable
     */
    protected $ResolucionesAreasConocimiento;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ResolucionesAreasConocimiento',
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
        $config = $this->getTableLocator()->exists('ResolucionesAreasConocimiento') ? [] : ['className' => ResolucionesAreasConocimientoTable::class];
        $this->ResolucionesAreasConocimiento = $this->getTableLocator()->get('ResolucionesAreasConocimiento', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ResolucionesAreasConocimiento);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ResolucionesAreasConocimientoTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ResolucionesAreasConocimientoTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
