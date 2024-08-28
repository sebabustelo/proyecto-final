<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrganismosFixture
 */
class OrganismosFixture extends TestFixture
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
                'descripcion' => 'Lorem ipsum dolor sit amet',
                'activo' => 1,
                'fecha_baja' => '2024-02-21 13:07:43',
                'created' => '2024-02-21 13:07:43',
                'created_by' => 'Lorem ipsum do',
                'modified' => '2024-02-21 13:07:43',
                'modified_by' => 'Lorem ipsum do',
                'nro_organismo' => 'Lorem ipsum dolor ',
            ],
        ];
        parent::init();
    }
}
