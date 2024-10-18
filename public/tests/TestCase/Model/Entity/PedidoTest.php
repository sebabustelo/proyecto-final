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

    /**
     * Test if Pedido object is initialized correctly
     *
     * @return void
     */
    public function testPedidoInitialization(): void
    {
        $this->assertInstanceOf(Pedido::class, $this->Pedido, "No se ha creado una instancia de Pedido correctamente.");
    }

    /**
     * Test setting and getting properties
     *
     * @return void
     */
    public function testSetAndGetProperty(): void
    {
        $this->Pedido->nombre = 'Test Pedido';
        $this->assertEquals('Test Pedido', $this->Pedido->nombre, "El nombre del pedido no coincide.");
    }
}
