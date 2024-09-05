<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductosFixture
 */
class ProductosFixture extends TestFixture
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
                'categoria_id' => 1,
                'proveedor_id' => 1,
                'imagen' => 'Lorem ipsum dolor sit amet',
                'stock' => 1,
                'created' => '2024-09-05 03:47:06',
                'modified' => '2024-09-05 03:47:06',
                'created_by' => 'Lorem ipsum dolor sit amet',
                'modified_by' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
