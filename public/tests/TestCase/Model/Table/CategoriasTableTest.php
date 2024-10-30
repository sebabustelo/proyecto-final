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
       
        'app.Categorias',
        'app.Proveedores',
        'app.Productos',

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
        $categoriaDuplicada = $this->Categorias->newEntity([
            'nombre' => 'Categoria Duplicada', // Asegúrate de que este nombre ya existe en los fixtures
            'descripcion' => 'Descripcion de la categoria duplicada',
            'created' => '2024-10-17 15:44:36',
            'modified' => '2024-10-17 15:44:36',
            'activo' => 1,

        ]);

        $this->Categorias->save($categoriaDuplicada);

        // Ahora intentamos guardar otra categoría con el mismo nombre
        $nuevaCategoria = $this->Categorias->newEntity([
            'nombre' => 'Categoria Duplicada',
            'descripcion' => 'Otra descripción',
            'created' => '2024-10-17 15:44:36',
            'modified' => '2024-10-17 15:44:36',
            'activo' => 1,
        ]);

        $result = $this->Categorias->save($nuevaCategoria);
        $this->assertFalse($result, 'La categoría fue guardada, pero debería haber fallado por violación de regla de unicidad.');
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
        $categoria = $this->Categorias->get(1);
        $producto = $this->Categorias->Productos->get(1);

        $result = $this->Categorias->delete($categoria);

        // Comprobar que la categoría no se eliminó debido a la asociación con un producto
        $this->assertFalse($result, 'La categoría fue eliminada, pero debería haber fallado debido a productos asociados.');

      
    }
}
