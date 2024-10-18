<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Categoria;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Categoria Test Case
 */
class CategoriaTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\Categoria
     */
    protected $Categoria;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->Categoria = new Categoria();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Categoria);

        parent::tearDown();
    }
}
