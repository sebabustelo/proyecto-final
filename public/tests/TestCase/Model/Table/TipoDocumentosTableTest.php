<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoDocumentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\ORM\Entity;

/**
 * App\Model\Table\TipoDocumentosTable Test Case
 */
class TipoDocumentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoDocumentosTable
     */
    protected $TipoDocumentos;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.TipoDocumentos',
        'app.RbacUsuarios',
        'app.RbacPerfiles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->TipoDocumentos = TableRegistry::getTableLocator()->get('TipoDocumentos');

    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TipoDocumentos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $tipoDocumento = $this->TipoDocumentos->newEntity([
            'descripcion' => ''
        ]);

        $this->assertFalse($this->TipoDocumentos->save($tipoDocumento));
        $this->assertArrayHasKey('descripcion', $tipoDocumento->getErrors());
        $this->assertSame('La descripción es obligatoria.', $tipoDocumento->getError('descripcion')['_empty']);
    }

    /**
     * Test beforeSave method - Verifica que el campo 'descripcion' se convierte en mayúsculas antes de guardar
     *
     * @return void
     */
    public function testBeforeSave(): void
    {
        $tipoDocumento = $this->TipoDocumentos->newEntity([
            'descripcion' => 'cuil'
        ]);
        $this->TipoDocumentos->save($tipoDocumento);

        // Verifica que el campo 'descripcion' se convirtió en mayúsculas
        $this->assertEquals('CUIL', $tipoDocumento->nombre);
    }

    /**
     * Test beforeDelete method - Verifica que no se puede eliminar un TipoDocumento si tiene usuarios asociados
     *
     * @return void
     */
    public function testBeforeDeleteWithAssociatedUsers(): void
    {
        $tipoDocumento = $this->TipoDocumentos->get(1); // Asume que el fixture tiene un TipoDocumento con usuarios asociados

        // Intenta eliminar el TipoDocumento
        $result = $this->TipoDocumentos->delete($tipoDocumento);

        // Verifica que no se haya eliminado y que haya un error en 'descripcion'
        $this->assertFalse($result);
        $this->assertArrayHasKey('descripcion', $tipoDocumento->getErrors());
        $this->assertFalse($result, 'El tipo de documento fue eliminado, pero debería haber fallado debido a usuarios asociados.');

    }

    /**
     * Test beforeDelete method - Verifica que se puede eliminar un TipoDocumento sin usuarios asociados
     *
     * @return void
     */
    public function testBeforeDeleteWithoutAssociatedUsers(): void
    {
        // Crea un nuevo tipo de documento sin usuarios asociados
        $tipoDocumento = $this->TipoDocumentos->newEntity([
            'descripcion' => 'Pasaporte'
        ]);
        $this->TipoDocumentos->save($tipoDocumento);

        // Verifica que se puede eliminar sin problemas
        $result = $this->TipoDocumentos->delete($tipoDocumento);
        $this->assertTrue($result);
    }
}
