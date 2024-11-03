<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\TipoDocumentosController Test Case
 *
 * Este caso de prueba contiene pruebas unitarias para el controlador
 * TipoDocumentosController. Se encarga de gestionar las operaciones
 * relacionadas con los tipos de documentos, incluyendo la validación
 * de condiciones de búsqueda y la interacción con la base de datos.
 *
 * @uses \App\Controller\TipoDocumentosController
 * @author Sebastián Bustelo
 * @version 1.0
 * @category Controladores
 * @see \App\Model\Table\TipoDocumentosTable
 */
class TipoDocumentosControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.TipoDocumentos',
        'app.RbacUsuarios',
        'app.RbacPerfiles'
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->initializeSession();
    }

    /**
     * Configura la sesión inicial para pruebas con datos de un usuario simulado
     */
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
                'TipoDocumentos' => [
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
     * Prueba el método index para verificar que la página se carga correctamente
     * @return void
     * @uses \App\Controller\TipoDocumentosController::index()
     */
    public function testIndex(): void
    {
        $this->get('/TipoDocumentos');

        $this->assertResponseOk();
        $filters = $this->viewVariable('filters');
        $this->assertNotNull($filters, 'Los filtros no fueron cargados correctamente.');
        $consultas = $this->viewVariable('tipoDocumentos');
        $this->assertNotEmpty($consultas, 'No se cargaron consultas en la vista.');
    }

    /**
     * Test add method
     *
     * Prueba el método add para verificar que un tipo de documento se agrega correctamente
     * @return void
     * @uses \App\Controller\TipoDocumentosController::add()
     */
    public function testAdd(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post('/TipoDocumentos/add', [
            'descripcion' => 'Pasaporte', // Ajusta los campos según tu modelo
        ]);

        $this->assertResponseSuccess();

        // Verifica que el nuevo tipo de documento se ha agregado a la base de datos
        $tipoDocumentos = $this->getTableLocator()->get('TipoDocumentos')->find()->all();

        // Verifica que el nuevo tipo de documento se haya guardado correctamente
        $nuevoTipoDocumento = $tipoDocumentos->last();
        $this->assertEquals('Pasaporte', $nuevoTipoDocumento->descripcion);
    }

    /**
     * Test testAddFailure method
     *
     * Prueba el método add para manejar fallos al agregar un tipo de documento con una descripción vacía
     * @return void
     * @uses \App\Controller\TipoDocumentosController::add()
     */
    public function testAddFailure()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $data =  [
            'descripcion' => '',
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post('/TipoDocumentos/add', $data);
        $this->assertResponseSuccess();

        // Verificamos que no se haya guardado ningun tipo de documento
        $tipoDocumentos = $this->getTableLocator()->get('TipoDocumentos');
        $tipoDocumento = $tipoDocumentos->find()->where(['descripcion' => ''])->first();
        $this->assertEmpty($tipoDocumento);
    }

    /**
     * Test testAddDuplicate method
     *
     * Prueba el método add para evitar duplicados
     * @return void
     * @uses \App\Controller\TipoDocumentosController::add()
     */
    public function testAddDuplicate()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        // Primero, inserta un registro con 'LE' en la base de datos
        $tipoDocumentos = $this->getTableLocator()->get('TipoDocumentos');
        $tipoDocumentos->save($tipoDocumentos->newEntity(['descripcion' => 'LE']));

        $data = [
            'descripcion' => 'LE',
        ];

        $this->post('/TipoDocumentos/add', $data);

        // Verifica que no haya un nuevo registro duplicado
        $count = $tipoDocumentos->find()->where(['descripcion' => 'LE'])->count();
        $this->assertEquals(1, $count, 'Se encontró un duplicado en la base de datos');
    }

    /**
     * Test edit method
     *
     * Prueba el método edit para verificar que los cambios en un tipo de documento se guardan correctamente
     * @return void
     * @uses \App\Controller\TipoDocumentosController::edit()
     */
    public function testEdit(): void
    {
        // ID de un tipo de documento existente
        $tipoDocumentoId = 1;

        $data =  [
            'id' => 1,
            'descripcion' => 'NUEVO',
            'activo' => 1,
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/TipoDocumentos/edit/{$tipoDocumentoId}", $data);

        // Verifica que hubo una redirección a la página de índice o a otra URL especificada
        $this->assertResponseCode(302);

        // Carga el tipo de documento de la base de datos y verifica los cambios
        $tipoDocumentos = $this->getTableLocator()->get('TipoDocumentos');
        $tipoDocumento = $tipoDocumentos->get($tipoDocumentoId);

        $this->assertEquals('NUEVO', $tipoDocumento->descripcion);
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
        $tipoDocumentoId = 1;

        $data =  [
            'id' => 1,
            'descripcion' => '',
            'activo' => 1,
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post("/TipoDocumentos/edit/{$tipoDocumentoId}", $data);
        $this->assertResponseSuccess();

        // Verificamos que no se haya guardado ningun tipo de documento
        $tipoDocumentos = $this->getTableLocator()->get('TipoDocumentos');
        $tipoDocumento = $tipoDocumentos->find()->where(['descripcion' => ''])->first();
        $this->assertEmpty($tipoDocumento);
    }

    public function testEditNotExist(): void
    {
        $tipoDocumentoId = 999;

        $data =  [
            'id' => '999',
            'descripcion' => 'TEST',
            'activo' => 1,
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/TipoDocumentos/edit/{$tipoDocumentoId}", $data);
        //$this->assertSession('El tipo de documento no existe.', 'Flash.flash.0.message');
        $this->assertResponseCode(302);
        //$this->assertSession('El tipo de documento no existe.', 'Flash.flash.0.message');
    }

    public function testEditBadArgument(): void
    {
        //tipo de documento no válida
        $this->get('/TipoDocumentos/edit/test');
        $this->assertResponseCode(302);
        $this->assertFlashMessage('El tipo de documento no es válido.');
    }


    /**
     * Test delete method
     *
     * Prueba el método delete para verificar que un tipo de documento se elimina correctamente
     * @return void
     * @uses \App\Controller\TipoDocumentosController::delete()
     */
    public function testDelete(): void
    {
        $tipoDocumentoId = 3;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/TipoDocumentos/delete/{$tipoDocumentoId}");

        // Verifica que hubo una redirección después de eliminar
        $this->assertResponseCode(302);

        // Carga el tipo de documento desde la base de datos para verificar que se ha eliminado
        $tipoDocumentos = $this->getTableLocator()->get('TipoDocumentos');
        $tipoDocumento = $tipoDocumentos->find()->where(['id' => $tipoDocumentoId])->first();

        $this->assertNull($tipoDocumento, 'El tipo de documento fue eliminado correctamente.');
    }

    /**
     * Test delete method
     *
     * Prueba que el método delete maneje correctamente la eliminación de un ID no existente
     * @return void
     * @uses \App\Controller\TipoDocumentosController::delete()
     */
    public function testDeleteNotExist(): void
    {
        $tipoDocumentoId = 99;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/TipoDocumentos/delete/{$tipoDocumentoId}");

        $this->assertResponseCode(302);
        $this->assertSession('El tipo de documento no existe.', 'Flash.flash.0.message');
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
        $tipoDocumentoId = 1;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->get("/TipoDocumentos/delete/{$tipoDocumentoId}");

        $this->assertResponseCode(302);
        $this->assertSession('Método HTTP no permitido.', 'Flash.flash.0.message');
    }

    /**
     * Test delete method
     *
     * Prueba el método delete para manejar la eliminación de tipos de documentos con usuarios asociados
     * @return void
     * @uses \App\Controller\TipoDocumentosController::delete()
     */
    public function testDeleteWithAssociatedUsers(): void
    {
        $tipoDocumentoId = 1;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/TipoDocumentos/delete/{$tipoDocumentoId}");

        $this->assertResponseCode(302);

        $this->assertSession('No se puede eliminar este tipo de documento porque tiene usuarios asociados.', 'Flash.flash.1.message');
    }

    public function testDeleteBadArgument(): void
    {
        $tipoDocumentoId = "tipo-documento-no-valido";

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/TipoDocumentos/delete/{$tipoDocumentoId}");
        $this->assertResponseCode(302);
        // $this->assertSession('El tipo de documento no es válido.', 'Flash.flash.0.message');
        $this->assertFlashMessage('El tipo de documento no es válido.');
    }


    /**
     * Test testGetConditions method
     *
     * Prueba el método index para validar las condiciones de búsqueda a partir de la URL
     * @return void
     * @uses \App\Controller\TipoDocumentosController::index()
     */
    public function testGetConditions()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();;

        $this->get('/TipoDocumentos/index?descripcion=ejemplo&activo=1');
        $this->assertResponseOk();

        // Acceder a la variable set en la respuesta
        $data =  $this->_controller->getRequest()->getQuery();

        if (isset($data['descripcion']) and !empty($data['descripcion'])) {
            $conditions['where'][] = ['TipoDocumentos.descripcion LIKE' => '%' . $data['descripcion'] . '%'];
        }

        if (isset($data['activo']) and !empty($data['activo'])) {
            $conditions['where'][] = ['TipoDocumentos.activo' => $data['activo']];
        }

        // Verifica las condiciones
        $this->assertEquals([
            'where' => [
                ['TipoDocumentos.descripcion LIKE' => '%ejemplo%'],
                ['TipoDocumentos.activo' => '1']
            ]
        ], $conditions);
    }
}
