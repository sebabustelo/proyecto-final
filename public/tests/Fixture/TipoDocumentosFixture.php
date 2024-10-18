<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TipoDocumentosFixture
 */
class TipoDocumentosFixture extends TestFixture
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
                'descripcion' => 'Lorem ipsum dolor sit amet',
                'created' => '2024-10-17 15:44:55',
                'modified' => '2024-10-17 15:44:55',
                'activo' => 1,
            ],
        ];
        parent::init();
    }
}
