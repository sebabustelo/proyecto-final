<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CargosFuncionariosFixture
 */
class CargosFuncionariosFixture extends TestFixture
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
                'cargo_id' => 1,
                'funcionario_id' => 1,
                'es_firmante' => 1,
                'es_interino' => 1,
                'activo' => 1,
                'fecha_baja' => '2024-02-21 13:08:11',
                'nombramiento' => '2024-02-21',
            ],
        ];
        parent::init();
    }
}
