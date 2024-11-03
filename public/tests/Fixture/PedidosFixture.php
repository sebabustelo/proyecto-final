<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PedidosFixture
 */
class PedidosFixture extends TestFixture
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
                'cliente_id' => 1,
                'estado_id' => 1,
                'direccion_id' => 1,
                'fecha_pedido' => '2024-10-30 16:00:27',
                'fecha_intevencion' => '2024-10-30',
                'comentario' => 'pedidos 1',
                'created' => '2024-10-30 16:00:27',
                'modified' => '2024-10-30 16:00:27',
            ],
            [
                'id' => 2,
                'cliente_id' => 1,
                'estado_id' => 1,
                'direccion_id' => 1,
                'fecha_pedido' => '2024-10-30 16:00:27',
                'fecha_intevencion' => '2024-10-30',
                'comentario' => 'pedidos 2',
                'created' => '2024-10-30 16:00:27',
                'modified' => '2024-10-30 16:00:27',
            ],
            [
                'id' => 3,
                'cliente_id' => 1,
                'estado_id' => 3,
                'direccion_id' => 1,
                'fecha_pedido' => '2023-10-30 16:00:27',
                'fecha_intevencion' => '2023-10-30',
                'comentario' => 'pedido 3',
                'created' => '2024-10-30 16:00:27',
                'modified' => '2024-10-30 16:00:27',
            ]
        ];
        parent::init();
    }
}
