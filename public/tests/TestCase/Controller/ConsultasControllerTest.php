<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ConsultasController;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\Mailer\Mailer;

/**
 * App\Controller\ConsultasController Test Case
 *
 * @uses \App\Controller\ConsultasController
 */
class ConsultasControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Consultas',
        'app.RbacUsuarios',
        'app.ConsultasEstados',

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
                'Consultas' => [
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
     * @uses \App\Controller\ConsultasController::index()
     */
    public function testIndex(): void
    {
        $this->get('/consultas');
        $this->assertResponseOk();

        // Verifica que los filtros sean asignados correctamente a la vista
        $filters = $this->viewVariable('filters');
        $this->assertNotNull($filters, 'Los filtros no fueron cargados correctamente.');

        // Verifica que la vista tiene acceso a las categorías paginadas
        $consultas = $this->viewVariable('consultas');

        $this->assertNotEmpty($consultas, 'No se cargaron consultas en la vista.');

        // Si hay datos en los fixtures, puedes verificar que una consulta en particular esté en la respuesta
        $this->assertResponseContains('quiero consultar zaraza');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\ConsultasController::add()
     */
    public function testAdd(): void
    {

        $data =  [

            'consulta_estado_id' => 1,
            'usuario_consulta_id' => 1,
            'usuario_respuesta_id' => 1,
            'motivo' => 'test',
            'respuesta' => '',
            'created' => '2024-10-17 15:44:39',
            'modified' => '2024-10-17 15:44:39',
        ];
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        // Definir el estado "PENDIENTE" en el fixture ConsultasEstados
        $this->post('/consultas/add', $data);
        $this->assertResponseSuccess();

        // // Verificar que se ha guardado una nueva consulta en la base de datos
        $consultasTable = $this->getTableLocator()->get('Consultas');
        $this->assertEquals(3, $consultasTable->find()->count());

        // Verificar que el estado de la consulta guardada sea "PENDIENTE"
        $consulta = $consultasTable->find()
            ->orderBy(['id' => 'DESC'])
            ->first();

        $estado = $consulta->consulta_estado_id
            ? $this->getTableLocator()->get('ConsultasEstados')->get($consulta->consulta_estado_id)->nombre
            : null;
        $this->assertEquals('PENDIENTE', $estado);
    }

    public function testAddFailure()
    {
        // Simulamos una solicitud POST con datos inválidos (por ejemplo, nombre vacío)
        $data =  [
            'id' => 1,
            'consulta_estado_id' => 1,
            'usuario_consulta_id' => 1,
            'usuario_respuesta_id' => 1,
            'motivo' => '',
            'respuesta' => '',
            'created' => '2024-10-17 15:44:39',
            'modified' => '2024-10-17 15:44:39',
        ];
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post('/consultas/add', $data);
        $this->assertResponseSuccess();

        // Verificamos que no se haya guardado ninguna categoría
        $categorias = $this->getTableLocator()->get('consultas');
        $categoria = $categorias->find()->where(['motivo' => ''])->first();

        $this->assertEmpty($categoria);
    }

    /**
     * Test response method
     *
     * @return void
     * @uses \App\Controller\ConsultasController::response()
     */
    public function testResponse(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testGetConditions()
    {

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        // Simula una consulta de request con datos
        $this->get('/consultas/index?motivo=test&descripcion=ejemplo&activo=1'); // Cambia la URL según sea necesario

        // Verifica que la respuesta contenga las condiciones esperadas
        $this->assertResponseOk();

        // Opcional: puedes acceder a la variable set en la respuesta
        $data =  $this->_controller->getRequest()->getQuery();

        if (isset($data['motivo']) and !empty($data['motivo'])) {
            $conditions['where'][] = ['Consultas.motivo LIKE' => '%' . $data['motivo'] . '%'];
        }

        if (isset($data['descripcion']) and !empty($data['descripcion'])) {
            $conditions['where'][] = ['Consultas.descripcion LIKE ' => '%' . $data['descripcion'] . '%'];
        }

        // Verifica las condiciones
        $this->assertEquals([
            'where' => [
                ['Consultas.motivo LIKE' => '%test%'],
                ['Consultas.descripcion LIKE ' => '%ejemplo%']
            ]
        ], $conditions);
    }

    public function testViewSuccess(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        // Accede a la vista de la consulta con ID 2
        $this->get('/Consultas/view/2');

        // Verifica que el código de respuesta sea 200 OK
        $this->assertResponseOk();

        $this->assertResponseContains('consulta');
    }

    public function testViewNotFound(): void
    {

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        // Intenta acceder a una consulta que no existe (por ejemplo, ID 999)
        $this->get('/Consultas/view/999');

        // Verifica que el código de respuesta sea 302 (redirección)
        $this->assertResponseCode(302);
    }



    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\ConsultasController::delete()
     */
    public function testDelete(): void
    {
        // ID de una categoría existente que se va a eliminar
        $consultaId = 1;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/consultas/delete/{$consultaId}");

        // Verifica que hubo una redirección después de eliminar
        $this->assertResponseCode(302);
        $this->assertFlashMessage('La consulta fue eliminada correctamente.');

        // Carga la categoría desde la base de datos para verificar que se ha eliminado
        $consultas = $this->getTableLocator()->get('Consultas');
        $categoria = $consultas->find()->where(['id' => $consultaId])->first();

        $this->assertNull($categoria, 'La consulta no fue eliminada correctamente.');
    }

    // public function testSendEmailSuccess()
    // {
    //     // Simula los datos que se pasarían a la función
    //     $datos = [
    //         'email' => 'test@example.com',
    //         'subject' => 'Test Subject',
    //         'template' => 'test_template',
    //         'motivo' => 'Test motivo',
    //         'respuesta' => 'Test respuesta'
    //     ];
    //     $this->enableCsrfToken();

    //     $this->enableSecurityToken();
    //     // Crea una solicitud HTTP simulada
    //     $this->post('/consultas/send-email', $datos); // Ajusta la ruta a la acción correspondiente

    //     // Verifica que el resultado esperado se obtenga
    //     $this->assertResponseOk(); // Verifica que la respuesta sea correcta
    //     // Puedes verificar el contenido del correo, pero eso requeriría un mock del Mailer
    // }



    // public function testSendEmailFailureMissingAction()
    // {
    //     // Simula datos que causen un MissingActionException
    //     $datos = [
    //         'email' => 'test@example.com',
    //         'subject' => 'Test Subject',
    //         'template' => 'missing_template', // Asegúrate de que esta plantilla no exista
    //     ];

    //     // Crea una instancia del controlador
    //     $controller = $this->_controller;

    //     // Espera que se lance la excepción y verifica que la Flash message esté establecida
    //     $this->expectException(MissingActionException::class);
    //     $controller->sendEmail($datos);

    //     // Aquí puedes verificar el mensaje de error también
    // }

    // public function testSendEmailUnexpectedError()
    // {
    //     // Simula datos que causen un error inesperado
    //     $datos = [
    //         'email' => 'test@example.com',
    //         'subject' => 'Test Subject',
    //         'template' => 'test_template',
    //     ];

    //     // Crea una instancia del controlador
    //     $controller = new ConsultasController();

    //     // Simula un error inesperado (puedes usar mocks o stubs si es necesario)
    //     // Por ejemplo, podrías lanzar una excepción intencionadamente
    //     $this->expectException(\Exception::class);
    //     $controller->sendEmail($datos);
    // }
}
