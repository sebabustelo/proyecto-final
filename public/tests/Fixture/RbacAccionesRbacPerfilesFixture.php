<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RbacAccionesRbacPerfilesFixture
 */
class RbacAccionesRbacPerfilesFixture extends TestFixture
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
                'rbac_accion_id' => 1,
                'rbac_perfil_id' => 1,
            ],
        ];
        parent::init();
    }
}
