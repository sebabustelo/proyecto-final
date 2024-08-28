<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ResolucionRelacionadasFixture
 */
class ResolucionRelacionadasFixture extends TestFixture
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
                'resolucion_modificadora_id' => 1,
                'resolucion_modificada_id' => 1,
            ],
        ];
        parent::init();
    }
}
