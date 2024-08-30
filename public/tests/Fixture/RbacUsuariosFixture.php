<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RbacUsuariosFixture
 */
class RbacUsuariosFixture extends TestFixture
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
                'perfil_id' => 1,
                'tipo_documento_id' => 1,
                'documento' => 'Lorem ipsum dolor sit amet',
                'usuario' => 'Lorem ipsum dolor sit amet',
                'nombre' => 'Lorem ipsum dolor sit amet',
                'apellido' => 'Lorem ipsum dolor sit amet',
                'direccion' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'seed' => 'Lorem ipsum dolor sit amet',
                'activo' => 1,
                'created' => '2024-08-30 02:05:23',
                'modified' => '2024-08-30 02:05:23',
                'created_by' => 'Lorem ipsum do',
                'modified_by' => 'Lorem ipsum do',
            ],
        ];
        parent::init();
    }
}
