<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CargosDocumentoTiposTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CargosDocumentoTiposTable Test Case
 */
class CargosDocumentoTiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CargosDocumentoTiposTable
     */
    protected $CargosDocumentoTipos;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.CargosDocumentoTipos',
        'app.Cargos',
        'app.DocumentoTipos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CargosDocumentoTipos') ? [] : ['className' => CargosDocumentoTiposTable::class];
        $this->CargosDocumentoTipos = $this->getTableLocator()->get('CargosDocumentoTipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CargosDocumentoTipos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CargosDocumentoTiposTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CargosDocumentoTiposTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
