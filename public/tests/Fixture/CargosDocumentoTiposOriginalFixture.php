<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CargosDocumentoTiposOriginalFixture
 */
class CargosDocumentoTiposOriginalFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'cargos_documento_tipos_original';
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
                'documento_tipo_id' => 1,
                'fecha_baja' => '2024-02-21 13:08:40',
            ],
        ];
        parent::init();
    }
}
