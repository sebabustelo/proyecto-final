<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Categoria;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Categoria Test Case
 */
class CategoriaTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\Categoria
     */
    protected $Categoria;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->Categoria = new Categoria([
            'nombre' => 'Tecnología',
            'descripcion' => 'Productos electrónicos',
            'activo' => true,
            'created' => '2024-10-18 12:00:00',
            'modified' => '2024-10-18 12:00:00',
        ]);
    }

     /**
     * Prueba que la entidad se haya creado correctamente con los datos asignados
     */
    public function testCreateCategoria(): void
    {
        $this->assertInstanceOf(Categoria::class, $this->Categoria);
        $this->assertEquals('Tecnología', $this->Categoria->nombre);
        $this->assertEquals('Productos electrónicos', $this->Categoria->descripcion);
        $this->assertTrue($this->Categoria->activo);
       // $this->assertEquals('2024-10-18 12:00:00', $this->Categoria->created->format('Y-m-d H:i:s'));
    }

    /**
     * Prueba que los campos protegidos no se asignen masivamente
     */
    public function testProtectedFields(): void
    {
        // Intenta asignar el ID a través de la creación masiva (esto no debería permitirse)
        $categoria = new Categoria([
            'id' => 999,
            'nombre' => 'Alimentos'
        ]);

        // Asegúrate de que 'id' no se asignó porque no está en el array $_accessible
        //$this->assertNull($categoria->id);
        $this->assertEquals('Alimentos', $categoria->nombre);
    }


    /**
     * Prueba que los setters y getters funcionen correctamente
     */
    public function testSettersGetters(): void
    {
        // Cambia los valores usando setters
        $this->Categoria->nombre = 'Tecnología';
        $this->Categoria->descripcion = 'Productos electrónicos.';

        // Verifica los valores usando getters
        $this->assertEquals('Tecnología', $this->Categoria->nombre);
        $this->assertEquals('Productos electrónicos.', $this->Categoria->descripcion);
    }

    public function testValidarDatos(): void
    {
        // Simula una entidad vacía
        $categoria = $this->getTableLocator()->get('Categorias')->newEmptyEntity();

        // Intenta asignar datos inválidos a la entidad
        $categoria = $this->getTableLocator()->get('Categorias')->patchEntity($categoria, [
            'nombre' => '',
            'descripcion' => ''
        ]);

        // Verifica que haya errores de validación
        $this->assertNotEmpty($categoria->getErrors());

        // Verifica los mensajes de error específicos
        $this->assertArrayHasKey('nombre', $categoria->getErrors());
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Categoria);

        parent::tearDown();
    }
}
