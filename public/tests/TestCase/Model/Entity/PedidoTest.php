<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Pedido;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Pedido Test Case
 */
class PedidoTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\Pedido
     */
    protected $Pedido;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->Pedido = new Pedido();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Pedido);

        parent::tearDown();
    }
}
