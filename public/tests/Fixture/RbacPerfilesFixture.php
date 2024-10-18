<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RbacPerfilesFixture
 */
class RbacPerfilesFixture extends TestFixture
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
                'descripcion' => 'Lorem ipsum dolor sit amet',
                'accion_default_id' => 1,
            ],
        ];
        parent::init();
    }
}
