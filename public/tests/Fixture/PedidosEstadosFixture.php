<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PedidosEstadosFixture
 */
class PedidosEstadosFixture extends TestFixture
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
                'nombre' => 'estado 1',
                'descripcion' => 'Lorem ipsum dolor sit amet',
                'activo' => 1,
                'created' => '2024-10-17 15:44:47',
                'modified' => '2024-10-17 15:44:47',
                'orden' => 1,
            ],
            [
                'id' => 2,
                'nombre' => 'PAGADO',
                'descripcion' => 'Lorem ipsum dolor sit amet',
                'activo' => 1,
                'created' => '2024-10-17 15:44:47',
                'modified' => '2024-10-17 15:44:47',
                'orden' => 1,
            ],
            [
                'id' => 3,
                'nombre' => 'PENDIENTE',
                'descripcion' => 'estado 3',
                'activo' => 1,
                'created' => '2024-10-17 15:44:47',
                'modified' => '2024-10-17 15:44:47',
                'orden' => 1,
            ]
        ];
        parent::init();
    }
}
