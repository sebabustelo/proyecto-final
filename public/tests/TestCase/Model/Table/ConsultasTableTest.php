<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsultasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConsultasTable Test Case
 */
class ConsultasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ConsultasTable
     */
    protected $Consultas;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Consultas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Consultas') ? [] : ['className' => ConsultasTable::class];
        $this->Consultas = $this->getTableLocator()->get('Consultas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Consultas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ConsultasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
