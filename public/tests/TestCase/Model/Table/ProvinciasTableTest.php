<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProvinciasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProvinciasTable Test Case
 */
class ProvinciasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProvinciasTable
     */
    protected $Provincias;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Provincias',
        'app.Localidades',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Provincias') ? [] : ['className' => ProvinciasTable::class];
        $this->Provincias = $this->getTableLocator()->get('Provincias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Provincias);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ProvinciasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {

        $provincia = $this->Provincias->newEntity([
            'nombre' => '', // Campo vacío
            'activo' => true,
        ]);

        // Validar la entidad
        $result = $this->Provincias->save($provincia);

        $this->assertFalse($result, 'La categoria fue guardada.');

        // Comprobar que hay errores de validación
        $this->assertNotEmpty($provincia->getErrors());
    }


    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ProvinciasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $data = [
            'nombre' => 'Formosa',
            'activo' => true,
        ];

        // Guardar la primera vez
        $provincia1 = $this->Provincias->newEntity($data);
        $this->Provincias->save($provincia1);

        $this->assertEmpty($provincia1->getErrors());

        // Intentar guardar una provincia con el mismo nombre
        $provincia2 = $this->Provincias->newEntity($data);
        $this->Provincias->save($provincia2);
        $this->assertNotEmpty($provincia2->getErrors()['nombre']); // Debe haber un error de unicidad
    }


    /**
     * Test beforeDelete method
     *
     * @return void
     * @uses \App\Model\Table\ProvinciasTable::beforeDelete()
     */
    public function testBeforeDeleteWithNoLocalidades(): void
    {
        // Crear una provincia sin localidades
        $provincia = $this->Provincias->newEntity(['nombre' => 'Provincia Sin Localidades']);
        $this->Provincias->save($provincia);

        // Intentar eliminar la provincia
        $result = $this->Provincias->delete($provincia);

        // Verificar que se eliminó correctamente
        $this->assertTrue($result); // Debe ser verdadero
    }

    public function testBeforeDeleteWithLocalidades(): void
    {
        // Crear una provincia
        $provincia = $this->Provincias->newEntity(['nombre' => 'Provincia Con Localidades']);
        $this->Provincias->save($provincia);

        // Crear una localidad asociada a esta provincia
        $localidad = $this->getTableLocator()->get('Localidades');
        $localidadEntity = $localidad->newEntity(['nombre' => 'Localidad 1', 'provincia_id' => $provincia->id]);
        $localidad->save($localidadEntity);

        // Intentar eliminar la provincia
        $result = $this->Provincias->delete($provincia);

        // Verificar que no se eliminó
        $this->assertFalse($result); // Debe ser falso
        $this->assertNotEmpty($provincia->getErrors()); // Debe haber errores
        $this->assertArrayHasKey('delete', $provincia->getErrors()); // Debe haber un error en el campo 'delete'
        $this->assertEquals(__('No se puede eliminar la provincia porque está asociada a una o más localidades.'), $provincia->getErrors()['delete'][0]);
    }
}
