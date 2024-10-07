<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdenesMedicasFixture
 */
class OrdenesMedicasFixture extends TestFixture
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
                'pedido_id' => 1,
                'descripcion' => 'Lorem ipsum dolor sit amet',
                'file_name' => 'Lorem ipsum dolor sit amet',
                'file_extension' => 'Lorem ip',
                'file_size' => 1,
                'file_path' => 'Lorem ipsum dolor sit amet',
                'created' => '2024-10-06 01:12:08',
                'modified' => '2024-10-06 01:12:08',
            ],
        ];
        parent::init();
    }
}
