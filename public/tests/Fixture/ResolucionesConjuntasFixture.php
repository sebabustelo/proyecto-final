<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ResolucionesConjuntasFixture
 */
class ResolucionesConjuntasFixture extends TestFixture
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
                'resolucion_origen' => 1,
                'resolucion_complementada' => 1,
                'fecha_baja' => '2024-02-21 13:06:42',
            ],
        ];
        parent::init();
    }
}
