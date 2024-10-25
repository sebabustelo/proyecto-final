<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Consulta;
use App\Model\Table\ConsultasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Consulta Test Case
 */
class ConsultaTest extends TestCase
{
    // Agrega esto al inicio de tu clase de prueba
    private ConsultasTable $consultasTable;

    // Y en el método setUp() de tu prueba
    protected function setUp(): void
    {
        parent::setUp();
        $this->consultasTable = $this->getTableLocator()->get('Consultas');
    }

    // Cambia el método testInaccessibleFields a
    public function testInaccessibleFields(): void
    {
        // Datos con un campo no accesible
        $data = [
            'usuario_consulta_id' => 1,
            'usuario_respuesta_id' => 2,
            'motivo' => 'Consulta sobre producto',
            'respuesta' => 'Respuesta de prueba',
            'id' => 999,  // ID no debería ser asignado
        ];

        // Usa el método newEntity para crear la entidad
        $consulta = $this->consultasTable->newEntity($data);

        // Verifica que el ID no haya sido asignado
        $this->assertNull($consulta->id, 'El ID debería ser null porque no es asignable.');
    }
}
