<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductosTable;
use Cake\TestSuite\TestCase;

class ProductosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductosTable
     */
    protected $Productos;

    public array $fixtures = [
        'app.Proveedores',
        'app.Productos',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Productos') ? [] : ['className' => ProductosTable::class];
        $this->Productos = $this->getTableLocator()->get('Productos', $config);
    }

    // Aquí van tus pruebas
}
