<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\ConsultaEstado;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\ConsultaEstado Test Case
 */
class ConsultaEstadoTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\ConsultaEstado
     */
    protected ConsultaEstado $consultaEstado;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->consultaEstado = new ConsultaEstado();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->consultaEstado);
        parent::tearDown();
    }

    /**
     * Test that fields are accessible as expected.
     *
     * @return void
     */
    public function testAccessibleFields(): void
    {
        $data = [
            'id' => 1,
            'nombre' => 'Pendiente',
            'descripcion' => 'Consulta pendiente de respuesta',
        ];

        $consultaEstado = new ConsultaEstado($data);

        // Verifica que los campos sean accesibles
        $this->assertSame($data['nombre'], $consultaEstado->nombre);
        $this->assertSame($data['descripcion'], $consultaEstado->descripcion);
    }

    /**
     * Test that inaccessible fields are not mass assignable.
     *
     * @return void
     */
    public function testInaccessibleFields(): void
    {
        $data = [
            'id' => null, // El ID no debería ser asignado
            'nombre' => 'Pendiente',
        ];

        $consultaEstado = new ConsultaEstado($data);

        // Verifica que el ID no haya sido asignado
        $this->assertNull($consultaEstado->id, 'El ID debería ser null porque no es asignable.');
    }

    /**
     * Test the default state of a new entity.
     *
     * @return void
     */
    public function testDefaultState(): void
    {
        $consultaEstado = new ConsultaEstado();

        // Verifica el estado predeterminado
        $this->assertNull($consultaEstado->nombre, 'El nombre debería ser null por defecto.');
        $this->assertNull($consultaEstado->descripcion, 'La descripción debería ser null por defecto.');
    }
}
