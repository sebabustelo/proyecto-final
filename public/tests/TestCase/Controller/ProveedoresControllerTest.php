<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ProveedoresController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ProveedoresController Test Case
 *
 * @uses \App\Controller\ProveedoresController
 */
class ProveedoresControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Proveedores',
        'app.Direcciones',
        'app.Localidades'
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->initializeSession();
    }

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
                'Proveedores' => [
                    'index' => 1,
                    'add' => 1,
                    'view' => 1,
                    'delete' => 1,
                ],
            ],
        ]);
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\ProveedoresController::index()
     */
    public function testIndex(): void
    {
        $this->get('/Proveedores');

        $this->assertResponseOk();

        // Verifica que los filtros sean asignados correctamente a la vista
        $filters = $this->viewVariable('filters');
        $this->assertNotNull($filters, 'Los filtros no fueron cargados correctamente.');

        // Verifica que la vista tiene acceso a las categorías paginadas
        $estados = $this->viewVariable('proveedores');

        $this->assertNotEmpty($estados, 'No se cargaron estados en la vista.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\ProveedoresController::add()
     */
    public function testAddSuccess()
    {

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        // Simulamos una solicitud POST con datos válidos
        $data = [
            'id' => 1,
            'nombre' => 'Proveedor de Prueba nuevo',
            'descripcion' => 'descripcion de prueba nueva.',
            'direccion_id' => 1,
            'celular' => 1115465542,
            'email' => 'test2@test.com',
            'cuit' => '20289991862',
            'created' => '2024-10-20 17:49:54',
            'modified' => '2024-10-20 17:49:54',
            'activo' => 1,
        ];

        $this->post('/proveedores/add', $data);
        $this->assertResponseSuccess();
    }


      /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\ProveedoresController::edit()
     */
    public function testEdit(): void
    {
        // ID de un proveedor existente
        $proveedorId = 1;

        // Datos de actualización para el proveedor
        $data =  [
            'id' => 1,
            'nombre' => 'Proveedor de Prueba cambiado',
            'descripcion' => 'Descripción de prueba cambiada.',
            'celular' => 1114087456,
            'activo' => 1,
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Proveedores/edit/{$proveedorId}", $data);

        // Verifica que hubo una redirección a la página de índice o a otra URL especificada
        $this->assertResponseCode(302);

        // Carga el proveedor de la base de datos y verifica los cambios
        $proveedores = $this->getTableLocator()->get('Proveedores');
        $proveedor = $proveedores->get($proveedorId);

       $this->assertEquals('Descripción de prueba cambiada.', $proveedor->descripcion);
       $this->assertEquals(1114087456, $proveedor->celular);
       $this->assertEquals('Proveedor de Prueba cambiado', $proveedor->nombre);
    }



    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\ProveedoresController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
