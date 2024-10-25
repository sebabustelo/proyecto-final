<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ConsultasEstadosFixture
 */
class ConsultasEstadosFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'nombre' => 'PENDIENTE',
                'descripcion' => 'Es el estado inicial cuando el usuario cliente envia una consulta desde el portal',
                'activo' => 1,
                'created' => '2024-10-17 15:44:41',
                'modified' => '2024-10-17 15:44:41',
            ],
            [
                'id' => 2,
                'nombre' => 'RESPONDIDO',
                'descripcion' => 'La consulta del cliente fue respondida por un usuario de IPMAGNA',
                'activo' => 1,
                'created' => '2024-10-17 15:44:41',
                'modified' => '2024-10-17 15:44:41',
            ]
        ];
        parent::init();
    }
}
