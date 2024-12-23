<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProvinciasFixture
 */
class ProvinciasFixture extends TestFixture
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
                'nombre' => 'Buenos Aires',
                'activo' => 1,
            ],
            [
                'id' => 2,
                'nombre' => 'Misiones',
                'activo' => 1,
            ],
        ];
        parent::init();
    }
}
