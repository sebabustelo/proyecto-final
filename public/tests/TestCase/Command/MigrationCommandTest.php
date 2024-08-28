<?php
declare(strict_types=1);

namespace App\Test\TestCase\Command;

use App\Command\MigrationCommand;
use Cake\Console\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Command\MigrationCommand Test Case
 *
 * @uses \App\Command\MigrationCommand
 */
class MigrationCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * Test buildOptionParser method
     *
     * @return void
     * @uses \App\Command\MigrationCommand::buildOptionParser()
     */
    public function testBuildOptionParser(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test execute method
     *
     * @return void
     * @uses \App\Command\MigrationCommand::execute()
     */
    public function testExecute(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
