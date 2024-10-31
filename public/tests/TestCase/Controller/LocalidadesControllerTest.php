<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\LocalidadesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\LocalidadesController Test Case
 *
 * @uses \App\Controller\LocalidadesController
 */
class LocalidadesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Localidades',
        'app.Provincias',
        'app.Direcciones',
    ];



    private function initializeSession(): void
    {
        $this->session([
            'RbacUsuario' => [
                'id' => 1,
                'perfil_id' => 1,
                'direccion_id' => 1,
                'usuario' => 'usuario_test',
                'email' => 'test@example.com',
                'nombre' => 'Nombre',
                'apellido' => 'Apellido',
                'tipo_documento_id' => 1,
                'documento' => '12345678',
                'cuit' => 1,
                'razon_social' => 'Empresa Test',
                'celular' => '123456789',
                'password' => 'password_hash',
                'seed' => 'seed_value',
                'activo' => 1,
                'created' => '2024-10-24 15:30:16',
                'modified' => '2024-10-24 15:30:16',
                'created_by' => 'Admin',
                'modified_by' => 'Admin',
            ],
            'RbacAcciones' => [
                'Localidades' => [
                    'index' => 1,
                    'add' => 1,
                    'view' => 1,
                    'delete' => 1,
                ],
            ],
        ]);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->initializeSession();
    }


    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\LocalidadesController::index()
     */
    public function testIndex(): void
    {
        $this->get('/localidades');

        $this->assertResponseOk();
        $filters = $this->viewVariable('filters');
        $this->assertNotNull($filters, 'Los filtros no fueron cargados correctamente.');
        $localidades = $this->viewVariable('localidades');
        $this->assertNotEmpty($localidades, 'No se cargaron consultas en la vista.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\LocalidadesController::add()
     */
    public function testAdd(): void
    {
        // Verifica la cantidad inicial de tipos de documentos (ajusta según tu fixture)
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post('/Localidades/add', [
            'provincia_id' => 1,
            'nombre' => 'Lujan',
            'activo' => 1,
        ]);

        $this->assertResponseSuccess();

        $localidades = $this->getTableLocator()->get('Localidades')->find()->all();

        // Verifica que el nuevo tipo de documento se haya guardado correctamente
        $nuevaLocalidad = $localidades->last();
        $this->assertEquals('Lujan', $nuevaLocalidad->nombre);
    }

    // /**
    //  * Test edit method
    //  *
    //  * @return void
    //  * @uses \App\Controller\LocalidadesController::edit()
    //  */
    // public function testEdit(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\LocalidadesController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test localidades method
     *
     * @return void
     * @uses \App\Controller\LocalidadesController::localidades()
     */
    public function testLocalidades(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
