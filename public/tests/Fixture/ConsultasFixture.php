<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ConsultasFixture
 */
class ConsultasFixture extends TestFixture
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
                'consulta_estado_id' => 1,
                'usuario_consulta_id' => 2,
                'usuario_respuesta_id' => 2,
                'motivo' => 'quiero consultar zaraza',
                'respuesta' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2024-10-17 15:44:39',
                'modified' => '2024-10-17 15:44:39',
            ],
            [
                'id' => 2,
                'consulta_estado_id' => 2,
                'usuario_consulta_id' => 2,
                'usuario_respuesta_id' => 2,
                'motivo' => 'quiero consultar test',
                'respuesta' => 'teststetststst.',
                'created' => '2024-10-17 15:44:39',
                'modified' => '2024-10-17 15:44:39',
            ]
        ];
        parent::init();
    }
}
