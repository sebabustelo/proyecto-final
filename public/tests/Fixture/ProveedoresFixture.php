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
                'nombre' => 'Proveedor de Prueba',
                'descripcion' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'direccion_id' => 1,
                'celular' => 1115465542,
                'email' => 'test@test.com',
                'cuit' => '20289991864',
                'created' => '2024-10-20 17:49:54',
                'modified' => '2024-10-20 17:49:54',
                'activo' => 1,
            ],
        ];
        parent::init();
    }
}
