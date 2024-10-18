<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Proveedor;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Proveedor Test Case
 */
class ProveedorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\Proveedor
     */
    protected $Proveedor;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->Proveedor = new Proveedor();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Proveedor);

        parent::tearDown();
    }
}
