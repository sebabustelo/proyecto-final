<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PalabrasClaveTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PalabrasClaveTable Test Case
 */
class PalabrasClaveTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PalabrasClaveTable
     */
    protected $PalabrasClave;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.PalabrasClave',
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
        $config = $this->getTableLocator()->exists('PalabrasClave') ? [] : ['className' => PalabrasClaveTable::class];
        $this->PalabrasClave = $this->getTableLocator()->get('PalabrasClave', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PalabrasClave);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PalabrasClaveTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PalabrasClaveTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
