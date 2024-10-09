<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductosPreciosFixture
 */
class ProductosPreciosFixture extends TestFixture
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
                'producto_id' => 1,
                'precio' => 1.5,
                'fecha_desde' => '2024-10-04 17:22:47',
                'fecha_hasta' => '2024-10-04 17:22:47',
            ],
        ];
        parent::init();
    }
}