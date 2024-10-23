<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocalidadesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocalidadesTable Test Case
 */
class LocalidadesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocalidadesTable
     */
    protected $Localidades;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Localidades',
        'app.Provincias',
        'app.Direcciones',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Localidades') ? [] : ['className' => LocalidadesTable::class];
        $this->Localidades = $this->getTableLocator()->get('Localidades', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Localidades);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LocalidadesTable::validationDefault()
     */
    public function testEmptyNombreValidation(): void
    {
        // Crear una nueva entidad de localidad con el campo 'nombre' vacío
        $localidad = $this->Localidades->newEntity([
            'nombre' => '',  // Campo vacío para probar la validación
            'provincia_id' => 1,
            'activo' => 1,
        ]);

        // Validar la entidad (sin intentar guardarla)
        $errors = $localidad->getErrors();

        // Verificar que hay un error en el campo 'nombre'
        $this->assertArrayHasKey('nombre', $errors, "El campo 'nombre' debería ser requerido.");
    }



    /**
     * Test beforeDelete method
     *
     * @return void
     * @uses \App\Model\Table\LocalidadesTable::beforeDelete()
     */
    public function testBeforeDelete(): void
    {
        // Crear un registro de ejemplo para simular una localidad asociada a una dirección
        $data = [
            'id' => 1,  // Asume que esta localidad está asociada a una dirección en el fixture
            'nombre' => 'Localidad Ejemplo',
            'provincia_id' => 1
        ];

        $localidad = $this->Localidades->get(1);  // Obtener una localidad existente

        // Intentar eliminar la localidad
        $result = $this->Localidades->delete($localidad);

        // Verificar que la eliminación fue rechazada porque está asociada a una dirección
        $this->assertFalse($result, 'La localidad asociada a una dirección no debería eliminarse');
    }
}
