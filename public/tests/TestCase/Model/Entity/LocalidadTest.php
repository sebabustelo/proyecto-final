<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Table\LocalidadesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Localidad Test Case
 */
class LocalidadTest extends TestCase
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
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->Localidades = $this->getTableLocator()->get('Localidades');
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
     * Test empty 'nombre' field validation
     *
     * @return void
     */
    public function testEmptyNombreValidation(): void
    {
        // Crear una nueva entidad con un campo 'nombre' vacío
        $localidad = $this->Localidades->newEntity([
            'nombre' => '',  // Campo vacío para probar la validación
            'provincia_id' => 1
        ]);

        // Obtener los errores de validación
        $errors = $localidad->getErrors();


        // Verificar que el error esté en el campo 'nombre'
        $this->assertArrayHasKey('nombre', $errors, 'La validación debería fallar si el campo nombre está vacío');
    }
}
