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
                'calle' => 'Padill',
                'numero' => '752',
                'piso' => '1',
                'departamento' => 'a',
                'localidad_id' => 1,
                'codigo_postal' => '1416',
            ],
        ];
        parent::init();
    }
}
