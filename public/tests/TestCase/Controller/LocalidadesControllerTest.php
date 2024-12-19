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
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post('/Localidades/add', [
            'provincia_id' => 1,
            'nombre' => 'Lujan',
            'activo' => 1,
        ]);

        $this->assertResponseSuccess();

        $localidades = $this->getTableLocator()->get('Localidades')->find()->all();

        $nuevaLocalidad = $localidades->last();
        $this->assertEquals('Lujan', $nuevaLocalidad->nombre);
    }

    public function testAddFailure()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post('/Localidades/add', [
            'provincia_id' => 1,
            'nombre' => '',
            'activo' => 1,
        ]);

        $this->assertResponseSuccess();

        // Verificamos que no se haya guardado ninguna localidad
        $localidades = $this->getTableLocator()->get('Localidades');
        $localidad = $localidades->find()->where(['nombre' => ''])->first();
        $this->assertEmpty($localidad);
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\LocalidadesController::edit()
     */
    public function testEdit(): void
    {
        // ID de un tipo de documento existente
        $localidadId = 1;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Localidades/edit/{$localidadId}", [
            'id' => 1,
            'provincia_id' => 1,
            'nombre' => 'PRUEBA DE EDICION',
            'activo' => 1,
        ]);

        $this->assertResponseCode(302);


        $localidades = $this->getTableLocator()->get('Localidades');

        $localidad = $localidades->get($localidadId);
        // debug($localidad);die;
        $this->assertEquals('PRUEBA DE EDICION', $localidad->nombre);
    }

    /**
     * Test testEditFailure method
     *
     * Prueba el método edit para manejar fallos al editar un tipo de documento con una descripción vacía
     * @return void
     * @uses \App\Controller\TipoDocumentosController::edit()
     */
    public function testEditFailure()
    {
        // ID de un tipo de documento existente
        $localidadId = 1;

        $data = [
            'provincia_id' => 1,
            'nombre' => '',
            'activo' => 1,
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post("/Localidades/edit/{$localidadId}", $data);
        $this->assertResponseSuccess();

        // Verificamos que no se haya guardado ningun tipo de documento
        $localidades = $this->getTableLocator()->get('Localidades');
        $localidad = $localidades->find()->where(['nombre' => ''])->first();
        $this->assertEmpty($localidad);
    }

    public function testEditNotExist(): void
    {
        $localidadId = 999;

        $data =  [
            'provincia_id' => 1,
            'nombre' => 'PRUEBA',
            'activo' => 1,
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Localidades/edit/{$localidadId}", $data);
        $this->assertResponseCode(302);
        //$this->assertSession('El tipo de documento no existe.', 'Flash.flash.0.message');
    }

    public function testEditBadArgument(): void
    {
        //tipo de documento no válida
        $this->get('/Localidades/edit/test');
        $this->assertResponseCode(302);
        $this->assertFlashMessage('La localidad no es válida.');
    }


    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\LocalidadesController::delete()
     */
    public function testDelete(): void
    {
        $localidadId = 3;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Localidades/delete/{$localidadId}");

        // Verifica que hubo una redirección después de eliminar
        $this->assertResponseCode(302);

        // Carga la localidad desde la base de datos para verificar que se ha eliminado
        $localidades = $this->getTableLocator()->get('Localidades');
        $localidad = $localidades->find()->where(['id' => $localidadId])->first();

        $this->assertNull($localidad, 'La localidad fue eliminado correctamente.');
    }

    /**
     * Test delete method
     *
     * Prueba que el método delete maneje correctamente la eliminación de un ID no existente
     * @return void
     * @uses \App\Controller\LocalidadesController::delete()
     */
    public function testDeleteNotExist(): void
    {
        $localidadId = 9999;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Localidades/delete/{$localidadId}");

        $this->assertResponseCode(302);
        $this->assertSession('La localidad no existe.', 'Flash.flash.0.message');
    }

    /**
     * Test delete method
     *
     * Prueba el método delete para verificar que responde con método no permitido en una solicitud GET
     * @return void
     * @uses \App\Controller\LocalidadesController::delete()
     */
    public function testDeleteMethodNotAllowed(): void
    {
        $localidadId = 1;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->get("/Localidades/delete/{$localidadId}");

        $this->assertResponseCode(302);
        $this->assertSession('Método HTTP no permitido.', 'Flash.flash.0.message');
    }

    /**
     * Test delete method
     *
     * Prueba el método delete para manejar la eliminación de localidad con provincias asociadas
     * @return void
     * @uses \App\Controller\LocalidadesController::delete()
     */
    public function testDeleteWithAssociatedProvincia(): void
    {
        $localidadId = 1;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Localidades/delete/{$localidadId}");

        $this->assertResponseCode(302);

        //$this->assertSession('No se pudo eliminar la localidad.', 'Flash.flash.1.message');
        $this->assertFlashMessage('No se pudo eliminar la localidad.');
    }

    public function testDeleteBadArgument(): void
    {
        $localidadId = "localidad-no-valida";

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Localidades/delete/{$localidadId}");
        $this->assertResponseCode(302);
        $this->assertFlashMessage('La localidad no es válida.');
    }



    /**
     * Test localidades method
     *
     * @return void
     * @uses \App\Controller\LocalidadesController::localidades()
     */
    public function testLocalidades(): void
    {
        $provinciaId = 1;

        $this->get("/localidades/localidades/$provinciaId");
        $this->assertContentType('application/json');
        $this->assertResponseOk();

        // Decodifica el JSON y verifica su estructura
        $localidades = json_decode((string)$this->_response->getBody(), true);
        // Asegura que el resultado es un array
        $this->assertIsArray($localidades);

        // Verifica que cada localidad en el resultado tenga los campos esperados
        foreach ($localidades as $localidad) {
            $this->assertArrayHasKey('id', $localidad);
            $this->assertArrayHasKey('nombre', $localidad);
        }
    }

    public function testGetConditions()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->get('/Localidades/index?nombre=ejemplo&provincia_id=1&activo=1');
        $this->assertResponseOk();

        // Acceder a la variable set en la respuesta
        $data =  $this->_controller->getRequest()->getQuery();

        if (isset($data['nombre']) and !empty($data['nombre'])) {
            $conditions['where'][] = ['Localidades.nombre LIKE' => '%' . $data['nombre'] . '%'];
        }

        if (isset($data['provincia_id']) and !empty($data['provincia_id'])) {
            $conditions['where'][] = ['Localidades.provincia_id' => $data['provincia_id']];
        }

        if (isset($data['activo']) and !empty($data['activo'])) {
            $conditions['where'][] = ['Localidades.activo' => $data['activo']];
        }

        // Verifica las condiciones
        $this->assertEquals([
            'where' => [
                ['Localidades.nombre LIKE' => '%ejemplo%'],
                ['Localidades.provincia_id' => '1'],
                ['Localidades.activo' => '1']
            ]
        ], $conditions);
    }
}
