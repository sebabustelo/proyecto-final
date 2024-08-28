<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UploadsFixture
 */
class UploadsFixture extends TestFixture
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
                'nombre_archivo' => 'Lorem ipsum dolor sit amet',
                'nombre_original' => 'Lorem ipsum dolor sit amet',
                'hash_archivo' => 'Lorem ipsum dolor sit amet',
                'extension_archivo' => 'Lorem ip',
                'hash_llave' => 'Lorem ipsum dolor sit amet',
                'subdir_zero' => 'Lorem ip',
                'created' => '2024-04-23 18:10:32',
                'modified' => '2024-04-23 18:10:32',
                'modified_by' => 1,
                'created_by' => 1,
            ],
        ];
        parent::init();
    }
}
