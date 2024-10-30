<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PedidosEstadosTable;
use Cake\TestSuite\TestCase;
use Cake\ORM\Exception\PersistenceFailedException;


/**
 * App\Model\Table\PedidosEstadosTable Test Case
 */
class PedidosEstadosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PedidosEstadosTable
     */
    protected $PedidosEstados;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.PedidosEstados',
        'app.Pedidos',
        'app.RbacUsuarios'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PedidosEstados') ? [] : ['className' => PedidosEstadosTable::class];
        $this->PedidosEstados = $this->getTableLocator()->get('PedidosEstados', $config);

        // Crear un estado con pedidos asociados si no existe en la base de datos de prueba
        $estado = $this->PedidosEstados->newEntity([
            'nombre' => 'Estado con Pedidos',
            'activo' => true,
        ]);
        $this->PedidosEstados->save($estado);

        $pedido = $this->PedidosEstados->Pedidos->newEntity([
            'estado_id' => $estado->id,
            // otros campos necesarios para crear un pedido...
        ]);
        $this->PedidosEstados->Pedidos->save($pedido);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PedidosEstados);

        parent::tearDown();
    }

    // Test para la validación del campo nombre único
    public function testValidationNombreUnique(): void
    {
        $estado = $this->PedidosEstados->newEntity([
            'nombre' => 'Nuevo Estado',
            'activo' => true,
        ]);
        $this->PedidosEstados->save($estado);

        $duplicado = $this->PedidosEstados->newEntity([
            'nombre' => 'Nuevo Estado',
            'activo' => true,
        ]);
        $this->assertFalse($this->PedidosEstados->save($duplicado));
        $this->assertArrayHasKey('nombre', $duplicado->getErrors());
    }

    // Test para el callback beforeSave que convierte 'nombre' en mayúsculas
    public function testBeforeSaveNombreToUppercase(): void
    {
        $estado = $this->PedidosEstados->newEntity([
            'nombre' => 'estado en minusculas',
            'activo' => true,
        ]);
        $this->PedidosEstados->save($estado);
        $this->assertEquals('ESTADO EN MINUSCULAS', $estado->nombre);
    }

    // Test para validar que no se elimine un estado con pedidos asociados
    public function testBeforeDeleteWithAssociatedPedidos(): void
    {
        $estado = $this->PedidosEstados->get(1); // Obtén un estado que tenga pedidos asociados en la base de datos de prueba
        $this->expectException(PersistenceFailedException::class);
        $this->PedidosEstados->delete($estado);

    }

    // Test para validar eliminación de un estado sin pedidos asociados
    public function testDeleteWithoutAssociatedPedidos(): void
    {
        $estado = $this->PedidosEstados->newEntity([
            'nombre' => 'Estado sin Pedidos',
            'activo' => true,
        ]);
        $this->PedidosEstados->save($estado);
        $this->assertTrue($this->PedidosEstados->delete($estado));
    }
}
