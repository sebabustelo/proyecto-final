<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CargosDocumentoTiposOriginalTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CargosDocumentoTiposOriginalTable Test Case
 */
class CargosDocumentoTiposOriginalTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CargosDocumentoTiposOriginalTable
     */
    protected $CargosDocumentoTiposOriginal;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.CargosDocumentoTiposOriginal',
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
        $config = $this->getTableLocator()->exists('CargosDocumentoTiposOriginal') ? [] : ['className' => CargosDocumentoTiposOriginalTable::class];
        $this->CargosDocumentoTiposOriginal = $this->getTableLocator()->get('CargosDocumentoTiposOriginal', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CargosDocumentoTiposOriginal);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CargosDocumentoTiposOriginalTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CargosDocumentoTiposOriginalTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
