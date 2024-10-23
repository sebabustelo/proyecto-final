<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Provincia;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Provincia Test Case
 */
class ProvinciaTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\Provincia
     */
    protected $Provincia;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->Provincia = new Provincia();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Provincia);

        parent::tearDown();
    }
}
