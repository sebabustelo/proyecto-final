<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProvinciasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProvinciasTable Test Case
 */
class ProvinciasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProvinciasTable
     */
    protected $Provincias;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Provincias',
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
        $config = $this->getTableLocator()->exists('Provincias') ? [] : ['className' => ProvinciasTable::class];
        $this->Provincias = $this->getTableLocator()->get('Provincias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Provincias);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ProvinciasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ProvinciasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test beforeDelete method
     *
     * @return void
     * @uses \App\Model\Table\ProvinciasTable::beforeDelete()
     */
    public function testBeforeDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
