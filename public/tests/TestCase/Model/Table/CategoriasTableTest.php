<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CategoriasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CategoriasTable Test Case
 */
class CategoriasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CategoriasTable
     */
    protected $Categorias;
    protected $Productos;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Proveedores',
        'app.Productos',
        'app.Categorias',

    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Categorias') ? [] : ['className' => CategoriasTable::class];
        $this->Categorias = $this->getTableLocator()->get('Categorias', $config);

        $config2 = $this->getTableLocator()->exists('Productos') ? [] : ['className' => ProductosTable::class];
        $this->Productos = $this->getTableLocator()->get('Productos', $config2);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Categorias);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CategoriasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        // Crear una nueva entidad de Categoría
        $categoria = $this->Categorias->newEntity([
            'id' => 1,
            'nombre' => '',
            'descripcion' => 'Lorem ipsum dolor sit amet',
            'created' => '2024-10-17 15:44:36',
            'modified' => '2024-10-17 15:44:36',
            'activo' => 1,
        ]);



        // Forzar un error de validación cambiando otro campo (por ejemplo, el estado activo)
        //$categoria->activo = null; // Esto debería causar un error si activo no puede ser nulo


        // Validar la entidad
        $result = $this->Categorias->save($categoria);

        $this->assertFalse($result, 'La categoria fue guardada.');

        // Comprobar que hay errores de validación
        $this->assertNotEmpty($categoria->getErrors());
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CategoriasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        // Crear una nueva categoría con un nombre duplicado
        $categoriaDuplicada = $this->Categorias->newEntity([
            'nombre' => 'Categoria Duplicada', // Asegúrate de que este nombre ya existe en los fixtures
            'descripcion' => 'Descripcion de la categoria duplicada',
            'created' => '2024-10-17 15:44:36',
            'modified' => '2024-10-17 15:44:36',
            'activo' => 1,

        ]);

        // Guardar la entidad
        $this->Categorias->save($categoriaDuplicada);

        // Ahora intentamos guardar otra categoría con el mismo nombre
        $nuevaCategoria = $this->Categorias->newEntity([
            'nombre' => 'Categoria Duplicada',
            'descripcion' => 'Otra descripción',
            'created' => '2024-10-17 15:44:36',
            'modified' => '2024-10-17 15:44:36',
            'activo' => 1,
        ]);

        // Guardar la entidad
        $result = $this->Categorias->save($nuevaCategoria);

        // Comprobar que la entidad no se guardó debido a una regla de unicidad
        $this->assertFalse($result, 'La categoría fue guardada, pero debería haber fallado por violación de regla de unicidad.');

        // Comprobar que hay errores de reglas
        $this->assertNotEmpty($nuevaCategoria->getErrors(), 'Se esperaban errores de reglas.');
    }

    /**
     * Test beforeDelete method
     *
     * @return void
     * @uses \App\Model\Table\CategoriasTable::beforeDelete()
     */
    public function testBeforeDelete(): void
    {
        // Asegúrate de que una categoría y un producto están configurados en los fixtures
        $categoria = $this->Categorias->get(1); // Obtiene la categoría desde los fixtures
        $producto = $this->Productos->get(1); // Obtiene el producto desde los fixtures

        // Intentar eliminar la categoría
        $result = $this->Categorias->delete($categoria);

        // Comprobar que la categoría no se eliminó debido a la asociación con un producto
        $this->assertFalse($result, 'La categoría fue eliminada, pero debería haber fallado debido a productos asociados.');

        // Ahora elimina el producto y vuelve a intentar eliminar la categoría
        $this->Productos->delete($producto);

        $result = $this->Categorias->delete($categoria);

        // Comprobar que la categoría fue eliminada correctamente
        $this->assertTrue($result, 'La categoría no fue eliminada correctamente.');
    }
}
