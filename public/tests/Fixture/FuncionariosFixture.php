<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FuncionariosFixture
 */
class FuncionariosFixture extends TestFixture
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
                'nombre' => 'Lorem ipsum dolor sit amet',
                'apellido' => 'Lorem ipsum dolor sit amet',
                'fecha_baja' => '2024-02-21 13:05:28',
                'activo' => 1,
                'nombre_migracion' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
