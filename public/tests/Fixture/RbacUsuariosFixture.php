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
                'direccion_id' => 1,
                'usuario' => 'Lorem ipsum dolor ',
                'email' => 'Lorem ipsum dolor sit amet',
                'nombre' => 'Lorem ipsum dolor sit amet',
                'apellido' => 'Lorem ipsum dolor sit amet',
                'tipo_documento_id' => 1,
                'documento' => 'Lorem ip',
                'cuit' => 1,
                'razon_social' => 'Lorem ipsum dolor sit amet',
                'celular' => 1,
                'password' => 'Lorem ipsum dolor sit amet',
                'seed' => 'Lorem ipsum dolor sit amet',
                'activo' => 1,
                'created' => '2024-10-17 15:44:54',
                'modified' => '2024-10-17 15:44:54',
                'created_by' => 'Lorem ipsum do',
                'modified_by' => 'Lorem ipsum do',
            ],
        ];
        parent::init();
    }
}
