<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProveedoresTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProveedoresTable Test Case
 */
class ProveedoresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProveedoresTable
     */
    protected $Proveedores;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Proveedores',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Proveedores') ? [] : ['className' => ProveedoresTable::class];
        $this->Proveedores = $this->getTableLocator()->get('Proveedores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Proveedores);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ProveedoresTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        // Datos válidos
        $validData =  [
            'id' => 1,
            'nombre' => 'Lorem ipsum dolor sit amet',
            'descripcion' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'direccion_id' => 1,
            'celular' => 1,
            'email' => 'test@test.com',
            'cuit' => '20289991868',
            'created' => '2024-10-20 17:49:54',
            'modified' => '2024-10-20 17:49:54',
            'activo' => 1,
        ];

        // Crea una entidad de proveedor con datos válidos
        $proveedor = $this->Proveedores->newEntity($validData);

        $this->assertEmpty($proveedor->getErrors(), 'Los datos válidos no deberían generar errores');

        // Datos inválidos (nombre vacío)
        $invalidData =  [  
            'nombre' => '',
            'descripcion' => 'Proveedor 1',
            'direccion_id' => 1,
            'celular' => 1,
            'email' => 'Lorem ipsum dolor sit amet',
            'cuit' => 'Lorem ipsum dolor ',
            'created' => '2024-10-20 17:49:54',
            'modified' => '2024-10-20 17:49:54',
            'activo' => 1,
        ];

        // Crea una entidad de proveedor con datos inválidos
        $proveedorInvalido = $this->Proveedores->newEntity($invalidData);
        $this->assertNotEmpty($proveedorInvalido->getErrors(), 'Los datos inválidos deberían generar errores');
    }


    /**
     * Test validarCuit method
     *
     * @return void
     * @uses \App\Model\Table\ProveedoresTable::validarCuit()
     */
    public function testValidarCuit(): void
    {
        // Ejemplo de un CUIT válido
        $data =  [
            'id' => 1,
            'nombre' => 'Lorem ipsum dolor sit amet',
            'descripcion' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'direccion_id' => 1,
            'celular' => 1,
            'email' => 'test@test.com',
            'cuit' => '20289991868',
            'created' => '2024-10-20 17:49:54',
            'modified' => '2024-10-20 17:49:54',
            'activo' => 1,
        ];
        $data['cuit'] = '20289991868';

        // Crea una entidad de proveedor con CUIT válido
        $proveedor = $this->Proveedores->newEntity($data);
        $this->assertEmpty($proveedor->getErrors(), 'El CUIT válido no debería generar errores');

        // Ejemplo de un CUIT inválido
        $data['cuit'] = '20267565391';

        // Crea una entidad de proveedor con CUIT inválido
        $proveedorInvalido = $this->Proveedores->newEntity($data);
        $this->assertNotEmpty($proveedorInvalido->getErrors(), 'El CUIT inválido debería generar errores');
    }
}
