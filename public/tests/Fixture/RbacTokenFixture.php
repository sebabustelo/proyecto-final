<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RbacTokenFixture
 */
class RbacTokenFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'rbac_token';
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
                'rbac_usuario_id' => 1,
                'token' => 'Lorem ipsum dolor sit amet',
                'created' => '2024-09-18 11:42:11',
                'modified' => '2024-09-18 11:42:11',
                'validez' => 1,
            ],
        ];
        parent::init();
    }
}
