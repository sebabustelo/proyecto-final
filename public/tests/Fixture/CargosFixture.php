<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CargosFixture
 */
class CargosFixture extends TestFixture
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
                'codigo' => 'Lorem ip',
                'descripcion' => 'Lorem ipsum dolor sit amet',
                'activo' => 1,
                'fecha_baja' => '2024-02-21 13:04:33',
            ],
        ];
        parent::init();
    }
}
