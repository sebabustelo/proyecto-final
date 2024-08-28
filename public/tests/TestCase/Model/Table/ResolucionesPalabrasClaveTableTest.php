<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResolucionesPalabrasClaveTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResolucionesPalabrasClaveTable Test Case
 */
class ResolucionesPalabrasClaveTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResolucionesPalabrasClaveTable
     */
    protected $ResolucionesPalabrasClave;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ResolucionesPalabrasClave',
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
        $config = $this->getTableLocator()->exists('ResolucionesPalabrasClave') ? [] : ['className' => ResolucionesPalabrasClaveTable::class];
        $this->ResolucionesPalabrasClave = $this->getTableLocator()->get('ResolucionesPalabrasClave', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ResolucionesPalabrasClave);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ResolucionesPalabrasClaveTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ResolucionesPalabrasClaveTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
