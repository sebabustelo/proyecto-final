<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ResolucionesPalabrasClaveFixture
 */
class ResolucionesPalabrasClaveFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'resoluciones_palabras_clave';
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
                'resolucion_id' => 1,
                'palabra' => 1,
                'fecha_baja' => '2024-02-21 13:06:31',
            ],
        ];
        parent::init();
    }
}
