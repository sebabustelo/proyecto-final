<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ConfiguracionFixture
 */
class ConfiguracionFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'configuracion';
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
                'clave' => 'Lorem ipsum dolor sit amet',
                'valor' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
