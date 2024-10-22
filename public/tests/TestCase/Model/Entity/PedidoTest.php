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
        $data =            [
            'id' => 1,
            'cliente_id' => 1,
            'estado_id' => 1,
            'direccion_id' => 1,
            'fecha_pedido' => '2024-10-17 15:44:46',
            'fecha_aplicacion' => '2024-10-17',
            'aclaracion' => 'zaraza',
            'created' => '2024-10-17 15:44:46',
            'modified' => '2024-10-17 15:44:46'
        ];
        $this->Pedido = new Pedido($data);
    }

    public function testCreatePedido(): void
    {
        $this->assertInstanceOf(Pedido::class, $this->Pedido);
        $this->assertEquals('zaraza', $this->Pedido->aclaracion);
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
        $this->Pedido->aclaracion = 'Test Pedido';
        $this->assertEquals('Test Pedido', $this->Pedido->aclaracion, "El nombre del pedido no coincide.");
    }
}
