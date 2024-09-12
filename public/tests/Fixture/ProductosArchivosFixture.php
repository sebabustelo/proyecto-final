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
                'file_name' => 'Lorem ipsum dolor sit amet',
                'file_extension' => 'Lorem ip',
                'file_size' => 1,
                'file_path' => 'Lorem ipsum dolor sit amet',
                'created' => '2024-09-12 12:31:48',
                'modified' => '2024-09-12 12:31:48',
            ],
        ];
        parent::init();
    }
}
