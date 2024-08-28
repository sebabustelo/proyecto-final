<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ResolucionesFixture
 */
class ResolucionesFixture extends TestFixture
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
                'numero' => 1,
                'anio' => 1,
                'documento_tipo_id' => 1,
                'fecha' => '2024-03-14',
                'titulo' => 'Lorem ipsum dolor sit amet',
                'areasadfas' => 'Lorem ip',
                'organismo' => 1,
                'cargo_firmante' => 1,
                'cargo_interino' => 1,
                'modifica_complementa' => 1,
                'fecha_baja' => '2024-03-14 18:42:17',
                'created' => '2024-03-14 18:42:17',
                'created_by' => 'Lorem ipsum do',
                'modified' => '2024-03-14 18:42:17',
                'modified_by' => 'Lorem ipsum do',
                'expediente' => 'Lorem ipsum dolor sit amet',
                'proyecto' => 'Lorem ipsum dolor sit amet',
                'nro_organismo' => 'Lorem ipsum dolor sit amet',
                'area_id' => 1,
            ],
        ];
        parent::init();
    }
}
