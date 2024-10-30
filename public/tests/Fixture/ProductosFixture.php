<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductosFixture
 */
class ProductosFixture extends TestFixture
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
                'nombre' => 'K-MOD',
                'categoria_id' => 1,
                'proveedor_id' => 1,
                'descripcion_breve' => 'zaraza k-mod',
                'descripcion_larga' => 'zarazaaaaaaa k-mod.',
                'stock' => 1,
                'created' => '2024-10-17 15:44:47',
                'modified' => '2024-10-17 15:44:47',
                'activo' => 1,
                'productos_precios' =>
                [
                    0 => [                     
                        'precio' => 250000.00,
                        'fecha_desde' => '2024-10-17 15:44:50',                       
                    ]
                ]
            ],
            [
                'id' => 2,
                'nombre' => 'K-MOD-REV',
                'categoria_id' => 1,
                'proveedor_id' => 1,
                'descripcion_breve' => 'zaraza k-mod-rev',
                'descripcion_larga' => 'zarazaaaaaaa k-mod-rev.',
                'stock' => 1,
                'created' => '2024-10-17 15:44:47',
                'modified' => '2024-10-17 15:44:47',
                'activo' => 1,
                'productos_precios' =>
                [
                    0 => [                        
                        'precio' => 250000.00,
                        'fecha_desde' => '2024-10-17 15:44:50',                       
                    ]
                ]
            ]
        ];
        parent::init();
    }
}
