<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ObrasSocialesFixture
 */
class ObrasSocialesFixture extends TestFixture
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
                'nombre' => 'Lorem ipsum dolor sit amet',
                'direccion' => 'Lorem ipsum dolor sit amet',
                'telefono' => 'Lorem ipsum dolor ',
                'email' => 'Lorem ipsum dolor sit amet',
                'cuit' => 'Lorem ipsum dolor ',
                'created' => '2024-09-09 17:30:26',
                'modified' => '2024-09-09 17:30:26',
            ],
        ];
        parent::init();
    }
}
