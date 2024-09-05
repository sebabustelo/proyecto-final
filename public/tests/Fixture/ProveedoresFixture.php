<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProveedoresFixture
 */
class ProveedoresFixture extends TestFixture
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
                'descripcion' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'direccion' => 'Lorem ipsum dolor sit amet',
                'telefono' => 'Lorem ipsum dolor ',
                'email' => 'Lorem ipsum dolor sit amet',
                'cuit' => 'Lorem ipsum dolor ',
                'created' => '2024-09-05 03:48:17',
                'modified' => '2024-09-05 03:48:17',
                'created_by' => 'Lorem ipsum dolor sit amet',
                'modified_by' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
