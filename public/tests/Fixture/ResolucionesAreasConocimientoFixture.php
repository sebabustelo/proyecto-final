<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ResolucionesAreasConocimientoFixture
 */
class ResolucionesAreasConocimientoFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'resoluciones_areas_conocimiento';
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
                'area' => 'Lorem ip',
                'fecha_baja' => '2024-02-21 13:06:52',
            ],
        ];
        parent::init();
    }
}
