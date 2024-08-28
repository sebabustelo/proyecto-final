<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UploadsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UploadsTable Test Case
 */
class UploadsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UploadsTable
     */
    protected $Uploads;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Uploads',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Uploads') ? [] : ['className' => UploadsTable::class];
        $this->Uploads = $this->getTableLocator()->get('Uploads', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Uploads);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\UploadsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
