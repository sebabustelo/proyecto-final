<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Producto;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Producto Test Case
 */
class ProductoTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\Producto
     */
    protected $Producto;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->Producto = new Producto();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Producto);

        parent::tearDown();
    }
}
