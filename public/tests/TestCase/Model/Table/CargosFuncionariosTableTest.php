<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CargosFuncionariosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CargosFuncionariosTable Test Case
 */
class CargosFuncionariosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CargosFuncionariosTable
     */
    protected $CargosFuncionarios;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.CargosFuncionarios',
        'app.Cargos',
        'app.Funcionarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CargosFuncionarios') ? [] : ['className' => CargosFuncionariosTable::class];
        $this->CargosFuncionarios = $this->getTableLocator()->get('CargosFuncionarios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CargosFuncionarios);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CargosFuncionariosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CargosFuncionariosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
