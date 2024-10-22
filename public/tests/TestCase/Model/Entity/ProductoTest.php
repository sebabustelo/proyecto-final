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
        $data =  [
            'id' => 1,
            'nombre' => 'Producto de Prueba',
            'categoria_id' => 1,
            'proveedor_id' => 1,
            'descripcion_breve' => 'Lorem ipsum dolor sit amet',
            'descripcion_larga' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'stock' => 1,
            'created' => '2024-10-17 15:44:47',
            'modified' => '2024-10-17 15:44:47',
            'activo' => 0,
        ];

        // Creación de la instancia de Producto con datos
        $this->Producto = new Producto($data);
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

    /**
     * Test if Producto object is initialized correctly
     *
     * @return void
     */
    public function testProductoInitialization(): void
    {
        $this->assertInstanceOf(Producto::class, $this->Producto, "No se ha creado una instancia de Producto correctamente.");
        $this->assertEquals('Producto de Prueba', $this->Producto->nombre, "El nombre del producto no coincide.");

    }

    /**
     * Test setting and getting properties
     *
     * @return void
     */
    public function testSetAndGetProperties(): void
    {
        // Cambiar el nombre del producto
        $this->Producto->nombre = 'Producto Actualizado';
        $this->assertEquals('Producto Actualizado', $this->Producto->nombre, "El nombre del producto no coincide después de actualizar.");


    }
}
