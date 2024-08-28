<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResolucionesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResolucionesTable Test Case
 */
class ResolucionesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResolucionesTable
     */
    protected $Resoluciones;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Resoluciones',
        'app.DocumentoTipos',
        'app.Areas',
        'app.Organismos',
        'app.CargosFuncionarios',
        'app.ResolucionesPalabrasClave',
        'app.Funcionarios',
        'app.PalabrasClave',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Resoluciones') ? [] : ['className' => ResolucionesTable::class];
        $this->Resoluciones = $this->getTableLocator()->get('Resoluciones', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Resoluciones);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ResolucionesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ResolucionesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
