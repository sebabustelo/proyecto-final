<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DireccionesFixture
 */
class DireccionesFixture extends TestFixture
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
                'calle' => 'Lorem ipsum dolor sit amet',
                'numero' => 'Lorem ip',
                'piso' => 'Lorem ip',
                'departamento' => 'Lorem ip',
                'localidad_id' => 1,
                'codigo_postal' => 'Lorem ip',
            ],
        ];
        parent::init();
    }
}
