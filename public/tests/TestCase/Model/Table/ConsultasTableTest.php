<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsultasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConsultasTable Test Case
 */
class ConsultasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ConsultasTable
     */
    protected $Consultas;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Consultas',
        'app.RbacUsuarios',
        'app.ConsultasEstados',
        // 'app.UsuarioRespuestas',

    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Consultas') ? [] : ['className' => ConsultasTable::class];
        $this->Consultas = $this->getTableLocator()->get('Consultas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Consultas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ConsultasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        // Crear una entidad con datos inválidos
        $invalidData = [
            'motivo' => '',  // Campo requerido vacío
            'descripcion' => 'Esta es una descripción válida'
        ];
        $consulta = $this->Consultas->newEntity($invalidData);

        // Verificar que hay errores de validación
        $this->assertFalse($this->Consultas->save($consulta));
        $errors = $consulta->getErrors();

        // Verificar que el campo 'titulo' tiene errores
        $this->assertArrayHasKey('motivo', $errors, "El campo 'titulo' debería ser obligatorio.");
    }


    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ConsultasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        // Crear entidad con usuario_id inexistente
        $invalidConsulta = $this->Consultas->newEntity([
            'usuario_consulta_id' => 9999,  // ID que no existe
            'motivo' => 'Consulta Inválida',
            'consulta_estado_id' => 1,
            'descripcion' => 'Descripción para una consulta inválida'
        ]);

        // Intentar guardar la entidad
        $result = $this->Consultas->save($invalidConsulta);

        // Verificar que el guardado falló
        $this->assertFalse($result, "La consulta no debería haberse guardado con un usuario inexistente.");

        // Verificar que se asignó un error a 'usuario_consulta_id'
        $errors = $invalidConsulta->getErrors();
        $this->assertArrayHasKey('usuario_consulta_id', $errors, "Debe haber un error en 'usuario_consulta_id' por no existir.");
    }
}
