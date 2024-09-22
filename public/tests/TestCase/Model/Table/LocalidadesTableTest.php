<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocalidadesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocalidadesTable Test Case
 */
class LocalidadesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocalidadesTable
     */
    protected $Localidades;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Localidades',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Localidades') ? [] : ['className' => LocalidadesTable::class];
        $this->Localidades = $this->getTableLocator()->get('Localidades', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Localidades);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LocalidadesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
