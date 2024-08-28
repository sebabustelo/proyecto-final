<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResolucionesConjuntasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResolucionesConjuntasTable Test Case
 */
class ResolucionesConjuntasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResolucionesConjuntasTable
     */
    protected $ResolucionesConjuntas;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ResolucionesConjuntas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ResolucionesConjuntas') ? [] : ['className' => ResolucionesConjuntasTable::class];
        $this->ResolucionesConjuntas = $this->getTableLocator()->get('ResolucionesConjuntas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ResolucionesConjuntas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ResolucionesConjuntasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
