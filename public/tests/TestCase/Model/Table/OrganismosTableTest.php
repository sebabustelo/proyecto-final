<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrganismosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrganismosTable Test Case
 */
class OrganismosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrganismosTable
     */
    protected $Organismos;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Organismos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Organismos') ? [] : ['className' => OrganismosTable::class];
        $this->Organismos = $this->getTableLocator()->get('Organismos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Organismos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OrganismosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
