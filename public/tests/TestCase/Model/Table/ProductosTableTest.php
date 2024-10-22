<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductosTable;
use Cake\TestSuite\TestCase;

class ProductosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductosTable
     */
    protected $Productos;

    public array $fixtures = [
        'app.Categorias',
        'app.Proveedores',
        'app.Productos',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Productos') ? [] : ['className' => ProductosTable::class];
        $this->Productos = $this->getTableLocator()->get('Productos', $config);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ProductosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        // Crear datos incompletos, 'nombre' esta vació
        $data =  [
            'id' => 1,
            'nombre' => '',
            'categoria_id' => 1,
            'proveedor_id' => 1,
            'descripcion_breve' => 'Lorem ipsum dolor sit amet',
            'descripcion_larga' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'stock' => 1,
            'created' => '2024-10-17 15:44:47',
            'modified' => '2024-10-17 15:44:47',
            'activo' => 0,
        ];

        // Crear una nueva entidad de producto
        $producto = $this->Productos->newEntity($data);

        // Verificar que la entidad tiene errores de validación
        $this->assertFalse($this->Productos->save($producto));

        // Verificar que el campo 'nombre' tiene un error
        $errors = $producto->getErrors();
        $this->assertArrayHasKey('nombre', $errors, "El campo 'nombre' debería ser requerido.");
    }



    /**
     * Test validation failure on invalid stock
     *
     * @return void
     */
    public function testValidationFailOnInvalidStock(): void
    {
        // Crear datos con un stock negativo
        $data =  [
            'id' => 1,
            'nombre' => 'Lorem ipsum dolor sit amet',
            'categoria_id' => 1,
            'proveedor_id' => 1,
            'descripcion_breve' => 'Lorem ipsum dolor sit amet',
            'descripcion_larga' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'stock' => -1,
            'created' => '2024-10-17 15:44:47',
            'modified' => '2024-10-17 15:44:47',
            'activo' => 1,
        ];

        // Crear una nueva entidad de producto
        $producto = $this->Productos->newEntity($data);

        // Verificar que la entidad tiene errores de validación
        $this->assertFalse($this->Productos->save($producto));

        // Verificar que el campo 'stock' tiene un error
        $errors = $producto->getErrors();
        $this->assertArrayHasKey('stock', $errors, "'El stock debe ser mayor que cero");
    }
}
