<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CategoriasFixture
 */
class CategoriasFixture extends TestFixture
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
                'nombre' => 'Cadera',
                'descripcion' => 'set para caderas',
                'created' => '2024-10-17 15:44:36',
                'modified' => '2024-10-17 15:44:36',
                'activo' => 1,
            ],
            [
                'id' => 2,
                'nombre' => 'Columna',
                'descripcion' => 'set para calomna',
                'created' => '2024-10-17 15:44:36',
                'modified' => '2024-10-17 15:44:36',
                'activo' => 1,
            ]
        ];
        parent::init();
    }
}
