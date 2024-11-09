<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class RbacTokenFixture extends TestFixture
{

    public string  $table = 'rbac_token';
    public $fields = [
        'id' => ['type' => 'integer', 'autoIncrement' => true, 'length' => 11, 'null' => false],
        'token' => ['type' => 'string', 'length' => 255, 'null' => false],
        'user_id' => ['type' => 'integer', 'length' => 11, 'null' => false],
        'expires_at' => ['type' => 'datetime', 'null' => false],
        'created' => ['type' => 'datetime', 'null' => false],
        'modified' => ['type' => 'datetime', 'null' => false],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
    ];

    // Definir las columnas de la tabla
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'token' => 'valid-token-1',
                'user_id' => 1,
                'expires_at' => '2024-12-31 23:59:59',
                'created' => '2024-01-01 00:00:00',
                'modified' => '2024-01-01 00:00:00',
            ],
            [
                'id' => 2,
                'token' => 'expired-token',
                'user_id' => 2,
                'expires_at' => '2023-01-01 00:00:00',  // Token expirado
                'created' => '2023-01-01 00:00:00',
                'modified' => '2023-01-01 00:00:00',
            ],
            [
                'id' => 3,
                'token' => 'valid-token-2',
                'user_id' => 1,
                'expires_at' => '2024-12-31 23:59:59',
                'created' => '2024-01-01 00:00:00',
                'modified' => '2024-01-01 00:00:00',
            ],

        ];

        parent::init();
    }

}
