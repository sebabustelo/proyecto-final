<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductosArchivosFixture
 */
class ProductosArchivosFixture extends TestFixture
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
                'producto_id' => 1,
                'file_name' => 'producto1.jpg',
                'file_extension' => 'jpg',
                'file_size' => 1,
                'file_path' => 'img',
                'created' => '2024-10-30 16:19:37',
                'modified' => '2024-10-30 16:19:37',
                'es_principal' => 1,
            ],
            [
                'id' => 2,
                'producto_id' => 2,
                'file_name' => 'producto2.jpg',
                'file_extension' => 'jpg',
                'file_size' => 1,
                'file_path' => 'img',
                'created' => '2024-10-30 16:19:37',
                'modified' => '2024-10-30 16:19:37',
                'es_principal' => 1,
            ]
        ];
        parent::init();
    }
}
