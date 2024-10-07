<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DetallesPedidosFixture
 */
class DetallesPedidosFixture extends TestFixture
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
                'pedido_id' => 1,
                'producto_id' => 1,
                'cantidad' => 1,
                'aclaracion' => 'Lorem ipsum dolor sit amet',
                'fecha_aplicacion' => '2024-10-06 22:45:49',
            ],
        ];
        parent::init();
    }
}
