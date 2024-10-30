<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PedidosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PedidosTable Test Case
 */
class PedidosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PedidosTable
     */
    protected $Pedidos;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Pedidos',
        //'plugin.Rbac.RbacUsuarios',
        'app.PedidosEstados',
        'app.DetallesPedidos',
        'app.OrdenesMedicas',
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
        $config = $this->getTableLocator()->exists('Pedidos') ? [] : ['className' => PedidosTable::class];
        $this->Pedidos = $this->getTableLocator()->get('Pedidos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Pedidos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PedidosTable::validationDefault()
     */
    public function testBuildRules(): void
    {
        // Crear un nuevo pedido con un cliente inexistente
        $pedido = $this->Pedidos->newEntity([
            'cliente_id' => null, // ID de cliente inexistente
            'estado_id' => null,
            'direccion_id' => 1,
            'nombre' => 'Pedido de prueba',
            'fecha_pedido' => '2024-10-17 15:44:46',
            'fecha_intervencion' => '2025-10-25',
        ]);

        $result = $this->Pedidos->save($pedido);

        // Verificar que el pedido no fue guardado
        $this->assertFalse($result, 'El pedido fue guardado, pero debería haber fallado por la regla de negocio.');

        $errors = $pedido->getErrors();

        // Si hay errores, asegurarnos de que estén relacionados con la regla de negocio de 'cliente_id'
        $this->assertArrayHasKey('cliente_id', $errors, 'El error debería estar relacionado con cliente_id.');
    }

    public function testBuildRulesNotExist(): void
    {
        // Crea una entidad con un cliente_id y estado_id no existentes
        $invalidEntity = $this->Pedidos->newEntity([
            'cliente_id' => 999, // Un ID inexistente en el fixture RbacUsuarios
            'estado_id' => 999 ,  // Un ID inexistente en el fixture PedidosEstados
            'direccion_id' => 1,
            'nombre' => 'Pedido de prueba',
            'fecha_pedido' => '2024-10-17 15:44:46',
            'fecha_intervencion' => '2025-10-25',
        ]);

        // Intenta guardar la entidad y verifica que falle
        $result = $this->Pedidos->save($invalidEntity);
        $this->assertFalse($result, 'La entidad se guardó a pesar de tener cliente_id y estado_id inválidos.');

        // Verifica los errores específicos para cada campo
        $errors = $invalidEntity->getErrors();
        $this->assertArrayHasKey('cliente_id', $errors, 'No se generó el error esperado en cliente_id.');
        $this->assertArrayHasKey('estado_id', $errors, 'No se generó el error esperado en estado_id.');
    }

    public function testValidationFechaIntervencion()
    {
        // Caso 1: fecha_intervencion vacía
        $entity = $this->Pedidos->newEntity([
            'cliente_id' => 1,
            'estado_id' => 1,
            'direccion_id' => 1,
            'nombre' => 'Pedido de prueba',
            'fecha_pedido' => '2024-10-17 15:44:46',
            'fecha_intervencion' => '',
        ]);

        $errors = $entity->getErrors();
        $this->assertArrayHasKey('fecha_intervencion', $errors);
        $this->assertSame('Debe ingresar una fecha de intervención.', $errors['fecha_intervencion']['_empty']);

        // Caso 2: fecha_intervencion igual o anterior a la fecha actual
        $entity = $this->Pedidos->newEntity([
            'cliente_id' => 1,
            'estado_id' => 1,
            'direccion_id' => 1,
            'nombre' => 'Pedido de prueba',
            'fecha_pedido' => '2024-10-17 15:44:46',
            'fecha_intervencion' => date('Y-m-d'),
        ]);
        $errors = $entity->getErrors();
        $this->assertArrayHasKey('fecha_intervencion', $errors);
        $this->assertSame('La fecha de intervención debe ser mayor a la fecha actual.', $errors['fecha_intervencion']['validFutureDate']);

        // Caso 3: fecha_intervencion en una fecha futura (debe ser válida)
        $futureDate = date('Y-m-d', strtotime('+1 day'));
        $entity = $this->Pedidos->newEntity([
            'cliente_id' => 1,
            'estado_id' => 1,
            'direccion_id' => 1,
            'nombre' => 'Pedido de prueba',
            'fecha_pedido' => '2024-10-17 15:44:46',
            'fecha_intervencion' => $futureDate,
        ]);

        $errors = $entity->getErrors();
        $this->assertArrayNotHasKey('fecha_intervencion', $errors, 'La fecha de intervención futura no debe dar error');
    }

}
