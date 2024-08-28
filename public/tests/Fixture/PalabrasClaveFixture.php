<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PalabrasClaveFixture
 */
class PalabrasClaveFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'palabras_clave';
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
                'palabra' => 'Lorem ipsum dolor sit amet',
                'descripcion' => 'Lorem ipsum dolor sit amet',
                'activo' => 1,
                'fecha_baja' => '2024-03-14 18:41:17',
                'created' => '2024-03-14 18:41:17',
                'created_by' => 'Lorem ipsum do',
                'modified' => '2024-03-14 18:41:17',
                'modified_by' => 'Lorem ipsum do',
            ],
        ];
        parent::init();
    }
}
