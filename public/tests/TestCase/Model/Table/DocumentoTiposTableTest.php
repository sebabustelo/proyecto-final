<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentoTiposTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentoTiposTable Test Case
 */
class DocumentoTiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentoTiposTable
     */
    protected $DocumentoTipos;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.DocumentoTipos',
        'app.CargosDocumentoTiposOriginal',
        'app.Resoluciones',
        'app.Cargos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DocumentoTipos') ? [] : ['className' => DocumentoTiposTable::class];
        $this->DocumentoTipos = $this->getTableLocator()->get('DocumentoTipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->DocumentoTipos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DocumentoTiposTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DocumentoTiposTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
