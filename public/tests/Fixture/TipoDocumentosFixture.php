<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TipoDocumentosFixture
 *
 * Esta clase define un conjunto de datos de prueba para la tabla de tipos de documentos.
 * Proporciona registros ficticios que pueden ser utilizados en pruebas automatizadas.
 *
 * @uses \Cake\TestSuite\Fixture\TestFixture
 */
class TipoDocumentosFixture extends TestFixture
{
    /**
     * Init method
     *
     * Inicializa los registros de la tabla de tipos de documentos con datos de ejemplo.
     *
     * @return void
     *
     * @example
     *  Ejemplo de uso:
     *  Al ejecutar pruebas, estos registros estarán disponibles
     *  para su uso en las pruebas de integración.
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'descripcion' => 'DNI',
                'created' => '2024-10-17 15:44:55',
                'modified' => '2024-10-17 15:44:55',
                'activo' => 1,
            ],
            [
                'id' => 2,
                'descripcion' => 'CUIT',
                'created' => '2024-10-17 15:44:55',
                'modified' => '2024-10-17 15:44:55',
                'activo' => 1,
            ],
            [
                'id' => 3,
                'descripcion' => 'LE',
                'created' => '2024-10-17 15:44:55',
                'modified' => '2024-10-17 15:44:55',
                'activo' => 1,
            ]
        ];
        parent::init();
    }
}
