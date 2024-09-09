<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ObrasSocialesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ObrasSocialesTable Test Case
 */
class ObrasSocialesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ObrasSocialesTable
     */
    protected $ObrasSociales;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ObrasSociales',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ObrasSociales') ? [] : ['className' => ObrasSocialesTable::class];
        $this->ObrasSociales = $this->getTableLocator()->get('ObrasSociales', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ObrasSociales);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ObrasSocialesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
