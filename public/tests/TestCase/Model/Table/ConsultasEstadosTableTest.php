<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsultasEstadosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConsultasEstadosTable Test Case
 */
class ConsultasEstadosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ConsultasEstadosTable
     */
    protected $ConsultasEstados;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ConsultasEstados',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ConsultasEstados') ? [] : ['className' => ConsultasEstadosTable::class];
        $this->ConsultasEstados = $this->getTableLocator()->get('ConsultasEstados', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ConsultasEstados);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ConsultasEstadosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        // Crear entidad con datos inválidos
        $invalidEntity = $this->ConsultasEstados->newEntity([
            'nombre' => '',  // Campo requerido vacío para probar la validación
        ]);

        $this->assertFalse($this->ConsultasEstados->save($invalidEntity));
        $errors = $invalidEntity->getErrors();
        $this->assertArrayHasKey('nombre', $errors, "El campo 'nombre' es requerido.");
    }


    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ConsultasEstadosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        // Crear entidad con datos que violan una regla, nombre exsistente creado en la fixture
        $invalidEntity = $this->ConsultasEstados->newEntity([
            'nombre' => 'PENDIENTE',
        ]);

        // Guardar debería fallar debido a la regla de unicidad
        $this->assertFalse($this->ConsultasEstados->save($invalidEntity));
    }


    /**
     * Test beforeSave method
     *
     * @return void
     * @uses \App\Model\Table\ConsultasEstadosTable::beforeSave()
     */
    public function testBeforeSave(): void
    {
        // Crear entidad válida
        $entity = $this->ConsultasEstados->newEntity([
            'nombre' => 'Nuevo Estado',
        ]);

        // Guardar la entidad
        $result = $this->ConsultasEstados->save($entity);

        // Verificar que el guardado fue exitoso
        $this->assertNotFalse($result);

    }
}
