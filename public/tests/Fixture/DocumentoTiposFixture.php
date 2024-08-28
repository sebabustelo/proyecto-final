<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentoTiposFixture
 */
class DocumentoTiposFixture extends TestFixture
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
                'codigo' => '',
                'descripcion' => '',
                'activo' => 1,
                'fecha_baja' => '2024-02-21 13:05:55',
            ],
        ];
        parent::init();
    }
}
