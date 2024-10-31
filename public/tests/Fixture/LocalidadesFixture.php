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
                'provincia_id' => 1,
                'nombre' => 'Chacabuco',
                'activo' => 1,
            ],
            [
                'id' => 2,
                'provincia_id' => 1,
                'nombre' => 'Balcarce',
                'activo' => 1,
            ]
        ];
        parent::init();
    }
}
