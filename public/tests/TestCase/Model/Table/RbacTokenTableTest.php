<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RbacTokenTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RbacTokenTable Test Case
 */
class RbacTokenTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RbacTokenTable
     */
    protected $RbacToken;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RbacToken') ? [] : ['className' => RbacTokenTable::class];
        $this->RbacToken = $this->getTableLocator()->get('RbacToken', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RbacToken);

        parent::tearDown();
    }
}
