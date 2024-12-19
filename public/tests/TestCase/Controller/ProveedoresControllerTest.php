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
            'nombre' => 'Proveedor de Prueba nuevo',
            'descripcion' => 'descripcion de prueba nueva.',
            'direccion_id' => 1,
            'celular' => 1115465542,
            'email' => 'test2@test.com',
            'cuit' => '27316180057',
            'created' => '2024-10-20 17:49:54',
            'modified' => '2024-10-20 17:49:54',
            'activo' => 1,
        ];

        $this->post('/proveedores/add', $data);
        $this->assertResponseSuccess();

        $this->assertFlashMessage('El proveedor se guardo correctamente.');
    }

    public function testAddFailure()
    {

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        // nombre vacio
        $data = [
            'nombre' => '',
            'descripcion' => 'descripcion de prueba nueva.',
            'direccion_id' => 1,
            'celular' => 1115465542,
            'email' => 'test2@test.com',
            'cuit' => '27316180057',
            'created' => '2024-10-20 17:49:54',
            'modified' => '2024-10-20 17:49:54',
            'activo' => 1,
        ];

        $this->post('/proveedores/add', $data);
        $this->assertResponseCode(200);


        // $this->assertFlashMessage('El proveedor no pudo ser guardada. Por favor, verifique los campos e intenete nuevamente.');

    }


    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\ProveedoresController::edit()
     */
    // public function testEdit(): void
    // {
    //     // ID de un proveedor existente
    //     $proveedorId = 1;

    //     // Datos de actualización para el proveedor
    //     $data =  [
    //         'id' => 1,
    //         'nombre' => 'Proveedor de Prueba cambiado',
    //         'descripcion' => 'Descripción de prueba cambiada.',
    //         'celular' => 1114087456,
    //         'activo' => 1,
    //         'direccion_id' => 1,

    //         'email' => 'test5@test.com',
    //         'cuit' => '27316180057',
    //         'created' => '2024-10-20 17:49:54',
    //         'modified' => '2024-10-20 17:49:54',
    //         'activo' => 1,
    //     ];

    //     $this->enableCsrfToken();
    //     $this->enableSecurityToken();
    //     $this->post("/Proveedores/edit/{$proveedorId}", $data);

    //     // Verifica que hubo una redirección a la página de índice o a otra URL especificada
    //     $this->assertResponseCode(302);

    //     // Carga el proveedor de la base de datos y verifica los cambios
    //     $proveedores = $this->getTableLocator()->get('Proveedores');

    //     $proveedor = $proveedores->get($proveedorId);
    //     debug($proveedor);die;
    //     $this->assertEquals('Descripción de prueba cambiada.', $proveedor->descripcion);
    //     $this->assertEquals(1114087456, $proveedor->celular);
    //     $this->assertEquals('Proveedor de Prueba cambiado', $proveedor->nombre);
    // }

    public function testEditFailure()
    {

        $proveedorId = 1;

        // Datos de actualización con nombre vacio
        $data =  [
            'id' => 1,
            'nombre' => '',
            'descripcion' => 'Descripción de prueba cambiada.',
            'celular' => 1114087456,
            'activo' => 1,
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post("/Proveedores/edit/{$proveedorId}", $data);
        $this->assertResponseSuccess();

        // Verificamos que no se haya guardado ningun proveedor
        $proveedores = $this->getTableLocator()->get('Proveedores');
        $proveedor = $proveedores->find()->where(['nombre' => ''])->first();
        $this->assertEmpty($proveedor);
    }

    public function testEditNotExist(): void
    {
        $proveedorId = 999;

        $data =  [
            'id' => '999',
            'descripcion' => 'TEST',
            'activo' => 1,
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Proveedores/edit/{$proveedorId}", $data);
        $this->assertResponseCode(302);
    }

    public function testEditBadArgument(): void
    {
        //proveedor no válida "test"
        $this->get('/Proveedores/edit/test');
        $this->assertResponseCode(302);
        $this->assertFlashMessage('El proveedor no es válido.');
    }

    public function testEditEmptyArgument(): void
    {
        //proveedor no válida
        $this->get('/Proveedores/edit/');
        $this->assertResponseCode(302);
        $this->assertFlashMessage('El proveedor no es válido.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\ProveedoresController::delete()
     */
    public function testDelete(): void
    {
        $proveedorId = 2;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Proveedores/delete/{$proveedorId}");
        $this->assertResponseCode(302);

        // Carga el tipo de documento desde la base de datos para verificar que se ha eliminado
        $proveedores = $this->getTableLocator()->get('TipoDocumentos');
        $proveedor = $proveedores->find()->where(['id' => $proveedorId])->first();

        $this->assertNull($proveedor, 'El proveedor fue eliminado correctamente.');
    }

    public function testDeleteNotExist(): void
    {
        $proveedorId = 99;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Proveedores/delete/{$proveedorId}");

        $this->assertResponseCode(302);
        $this->assertSession('El proveedor no existe.', 'Flash.flash.0.message');
    }

    /**
     * Test delete method
     *
     * Prueba el método delete para verificar que responde con método no permitido en una solicitud GET
     * @return void
     * @uses \App\Controller\TipoDocumentosController::delete()
     */
    public function testDeleteMethodNotAllowed(): void
    {
        $proveedorId = 1;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->get("/Proveedores/delete/{$proveedorId}");

        $this->assertResponseCode(302);
        $this->assertSession('Método HTTP no permitido.', 'Flash.flash.0.message');
    }

    public function testDeleteBadArgument(): void
    {
        $proveedorId = "proveedor-no-valido";

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Proveedores/delete/{$proveedorId}");
        $this->assertResponseCode(302);
        $this->assertFlashMessage('El proveedor no es válido.');
    }

    public function testDeleteEmpty(): void
    {
        $proveedorId = '';
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Proveedores/delete/{$proveedorId}");
        $this->assertResponseCode(302);
        $this->assertFlashMessage('El proveedor no es válido.');
    }

    /**
     * Test testGetConditions method
     *
     * Prueba el método index para validar las condiciones de búsqueda a partir de la URL
     * @return void
     * @uses \App\Controller\ProveedoresController::index()
     */
    public function testGetConditions()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();;

        $this->get('/Proveedores/index?nombre=ejemplo&activo=1&cuit=2028999186&email=seba@test.com');
        $this->assertResponseOk();

        // Acceder a la variable set en la respuesta
        $data =  $this->_controller->getRequest()->getQuery();

        if (isset($data['nombre']) and !empty($data['nombre'])) {
            $conditions['where'][] = ['Proveedores.nombre LIKE' => '%' . $data['nombre'] . '%'];
        }

        // if (isset($data['cuit']) and !empty($data['cuit'])) {
        //     $conditions['where'][] = ['Proveedores.cuit' => $data['cuit']];
        // }

        if (isset($data['email']) and !empty($data['email'])) {
            $conditions['where'][] = ['Proveedores.email LIKE' => '%' . $data['email'] . '%'];
        }

        if (isset($data['activo']) and !empty($data['activo'])) {
            $conditions['where'][] = ['Proveedores.activo' => $data['activo']];
        }

        // Verifica las condiciones
        $this->assertEquals([
            'where' => [
                ['Proveedores.nombre LIKE' => '%ejemplo%'],
                ['Proveedores.email LIKE' => '%seba@test.com%'],
                //['Proveedores.cuit' => '2028999186'],
                ['Proveedores.activo' => '1']
            ]
        ], $conditions);
    }
}
