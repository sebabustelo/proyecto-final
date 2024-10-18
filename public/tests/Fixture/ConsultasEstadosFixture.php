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
                'nombre' => 'Lorem ipsum dolor sit amet',
                'descripcion' => 'Lorem ipsum dolor sit amet',
                'activo' => 1,
                'created' => '2024-10-17 15:44:41',
                'modified' => '2024-10-17 15:44:41',
            ],
        ];
        parent::init();
    }
}
