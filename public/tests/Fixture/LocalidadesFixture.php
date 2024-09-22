<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LocalidadesFixture
 */
class LocalidadesFixture extends TestFixture
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
                'id_provincia' => 1,
                'localidad' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
