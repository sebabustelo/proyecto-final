<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\TipoDocumento;
use Cake\TestSuite\TestCase;
use Cake\I18n\DateTime;

/**
 * App\Model\Entity\TipoDocumento Test Case
 */
class TipoDocumentoTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\TipoDocumento
     */
    protected $TipoDocumento;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Inicializa la entidad con los datos
        $this->TipoDocumento = new TipoDocumento([
            'descripcion' => 'CUIL',
            'activo' => true,
            'created' => new DateTime('2024-10-18 12:00:00')
        ]);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TipoDocumento);

        parent::tearDown();
    }

    /**
     * Prueba que la entidad se haya creado correctamente con los datos asignados
     */
    public function testCreateTipoDocumento(): void
    {
        $this->assertInstanceOf(TipoDocumento::class, $this->TipoDocumento);
        $this->assertEquals('CUIL', $this->TipoDocumento->descripcion);
        $this->assertTrue($this->TipoDocumento->activo);
        $this->assertEquals('2024-10-18 12:00:00', $this->TipoDocumento->created->format('Y-m-d H:i:s'));
    }
}
