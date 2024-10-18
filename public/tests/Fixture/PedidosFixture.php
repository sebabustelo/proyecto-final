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
                'fecha_pedido' => '2024-10-17 15:44:46',
                'fecha_aplicacion' => '2024-10-17',
                'aclaracion' => 'Lorem ipsum dolor sit amet',
                'created' => '2024-10-17 15:44:46',
                'modified' => '2024-10-17 15:44:46',
            ],
        ];
        parent::init();
    }
}
