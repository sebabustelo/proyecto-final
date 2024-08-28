<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PersonasExternasFixture
 */
class PersonasExternasFixture extends TestFixture
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
                'nombre' => 'Lorem ipsum dolor sit amet',
                'created' => '2024-02-21 13:07:23',
                'created_by' => 'Lorem ipsum do',
                'modified' => '2024-02-21 13:07:23',
                'modified_by' => 'Lorem ipsum do',
            ],
        ];
        parent::init();
    }
}
