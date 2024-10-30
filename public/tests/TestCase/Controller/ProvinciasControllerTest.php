<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ProvinciasController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ProvinciasController Test Case
 *
 * @uses \App\Controller\ProvinciasController
 */
class ProvinciasControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Provincias',
        'app.Localidades',
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
                'Provincias' => [
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
     * @uses \App\Controller\ProvinciasController::index()
     */
    public function testIndex(): void
    {
        $this->get('/Provincias');

        $this->assertResponseOk();
        $filters = $this->viewVariable('filters');
        $this->assertNotNull($filters, 'Los filtros no fueron cargados correctamente.');
        $provincias = $this->viewVariable('provincias');
        $this->assertNotEmpty($provincias, 'No se cargaron consultas en la vista.');
    }
    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\ProvinciasController::add()
     */
    public function testAdd(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post('/Provincias/add', [
            'nombre' => 'Provincia de prueba',
        ]);
        $this->assertResponseSuccess();

        // Verifica que provincia se ha agregado a la base de datos
        $provincias = $this->getTableLocator()->get('Provincias')->find()->all();

        // Verifica que el nuevo tipo de documento se haya guardado correctamente
        $provincia = $provincias->last();
        $this->assertEquals('Provincia de prueba', $provincia->nombre);
    }

    public function testAddFailure()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post('/Provincias/add', [
            'nombre' => '',
        ]);
        $this->assertResponseSuccess();

        // Verificamos que no se haya guardado la provincia
        $provincias = $this->getTableLocator()->get('Provincias');
        $provincia = $provincias->find()->where(['nombre' => ''])->first();
        $this->assertEmpty($provincia);
    }

    public function testAddDuplicate()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        // Primero, inserta una provincia con 'Formosa' en la base de datos
        $provincias = $this->getTableLocator()->get('Provincias');
        $provincias->save($provincias->newEntity(['nombre' => 'Formosa']));

        $this->post('/Provincias/add', [
            'nombre' => 'Formosa',
        ]);

        // Verifica que no haya una nueva provincia duplicada
        $count = $provincias->find()->where(['nombre' => 'Formosa'])->count();
        $this->assertEquals(1, $count, 'Se encontró un duplicado en la base de datos');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\ProvinciasController::edit()
     */
    public function testEdit(): void
    {
        // ID de un tipo de documento existente
        $provinciaId = 1;

        $data =  [
            'id' => 1,
            'nombre' => 'NUEVO',
            'activo' => 1,
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Provincias/edit/{$provinciaId}", $data);

        // Verifica que hubo una redirección a la página de índice o a otra URL especificada
        $this->assertResponseCode(302);

        // Carga la provincia de la base de datos y verifica los cambios
        $provincias = $this->getTableLocator()->get('Provincias');
        $provincia = $provincias->get($provinciaId);

        $this->assertEquals('NUEVO', $provincia->nombre);
    }

    public function testEditFailure()
    {
        // ID de una provincia existente
        $provinciaId = 1;

        $data =  [
            'id' => 1,
            'nombre' => '',
            'activo' => 1,
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post("/Provincias/edit/{$provinciaId}", $data);
        $this->assertResponseSuccess();

        // Verificamos que no se haya guardado la provincia
        $provincias = $this->getTableLocator()->get('Provincias');
        $provincia = $provincias->find()->where(['nombre' => ''])->first();
        $this->assertEmpty($provincia);
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\ProvinciasController::delete()
     */
    public function testDelete(): void
    {
        $provinciaId = 2;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Provincias/delete/{$provinciaId}");

        // Verifica que hubo una redirección después de eliminar
        $this->assertResponseCode(302);

        // Carga el tipo de documento desde la base de datos para verificar que se ha eliminado
        $provincias = $this->getTableLocator()->get('Provincias');
        $provincia = $provincias->find()->where(['id' => $provinciaId])->first();

        $this->assertNull($provincia, 'La provincia fue eliminado correctamente.');
    }

    public function testDeleteNotExist(): void
    {
        $provinciaId = 99;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Provincias/delete/{$provinciaId}");
        $this->assertResponseCode(302);
        $this->assertSession('La provincia no existe.', 'Flash.flash.0.message');
    }

    public function testDeleteMethodNotAllowed(): void
    {
        $provinciaId = 1;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->get("/Provincias/delete/{$provinciaId}");

        $this->assertResponseCode(302);
        $this->assertSession('Método HTTP no permitido.', 'Flash.flash.0.message');
    }

    public function testGetConditions()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();;

        $this->get('/Provincias/index?nombre=Buenos Aires&activo=1');
        $this->assertResponseOk();

        // Acceder a la variable set en la respuesta
        $data =  $this->_controller->getRequest()->getQuery();

        if (isset($data['nombre']) and !empty($data['nombre'])) {
            $conditions['where'][] = ['Provincias.nombre LIKE' => '%' . $data['nombre'] . '%'];
        }

        if (isset($data['activo']) and !empty($data['activo'])) {
            $conditions['where'][] = ['Provincias.activo' => $data['activo']];
        }

        // Verifica las condiciones
        $this->assertEquals([
            'where' => [
                ['Provincias.nombre LIKE' => '%Buenos Aires%'],
                ['Provincias.activo' => '1']
            ]
        ], $conditions);
    }
}
