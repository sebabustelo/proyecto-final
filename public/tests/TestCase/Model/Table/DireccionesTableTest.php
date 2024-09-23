<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DireccionesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DireccionesTable Test Case
 */
class DireccionesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DireccionesTable
     */
    protected $Direcciones;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Direcciones') ? [] : ['className' => DireccionesTable::class];
        $this->Direcciones = $this->getTableLocator()->get('Direcciones', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Direcciones);

        parent::tearDown();
    }
}
