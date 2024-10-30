<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Provincia;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Provincia Test Case
 */
class ProvinciaTest extends TestCase
{
     /**
     * Test subject
     *
     * @var \App\Model\Table\ProvinciasTable
     */
    protected $Provincias;

    protected array $fixtures = [      
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
        $this->Provincias = $this->getTableLocator()->get('Provincias');
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

    public function testEmptyNombreValidation(): void
    {
        // Crear una nueva entidad con un campo 'nombre' vacío
        $provincia = $this->Provincias->newEntity([
            'nombre' => '',            
        ]);

        // Obtener los errores de validación
        $errors = $provincia->getErrors();

        // Verificar que el error esté en el campo 'nombre'
        $this->assertArrayHasKey('nombre', $errors, 'La validación debería fallar si el campo nombre está vacío');
    }
}
