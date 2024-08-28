<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PersonasExternasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PersonasExternasTable Test Case
 */
class PersonasExternasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PersonasExternasTable
     */
    protected $PersonasExternas;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.PersonasExternas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PersonasExternas') ? [] : ['className' => PersonasExternasTable::class];
        $this->PersonasExternas = $this->getTableLocator()->get('PersonasExternas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PersonasExternas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PersonasExternasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PersonasExternasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
