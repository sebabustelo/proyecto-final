<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ConsultasEstadosController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ConsultasEstadosController Test Case
 *
 * @uses \App\Controller\ConsultasEstadosController
 */
class ConsultasEstadosControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ConsultasEstados',
        'app.Consultas',
        'app.RbacUsuarios'
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
                'ConsultasEstados' => [
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
     * @uses \App\Controller\ConsultasEstadosController::index()
     */
    public function testIndex(): void
    {
        $this->get('/ConsultasEstados');

        $this->assertResponseOk();

        // Verifica que los filtros sean asignados correctamente a la vista
        $filters = $this->viewVariable('filters');
        $this->assertNotNull($filters, 'Los filtros no fueron cargados correctamente.');

        // Verifica que la vista tiene acceso a las categorías paginadas
        $estados = $this->viewVariable('estados');

        $this->assertNotEmpty($estados, 'No se cargaron estados en la vista.');
    }
    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\ConsultasEstadosController::add()
     */
    public function testAddSuccess()
    {

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        // Simulamos una solicitud POST con datos válidos
        $data =  [
            'id' => 3,
            'nombre' => 'TEST NUEVO',
            'descripcion' => 'nuevo estado',
            'activo' => 1,
            'created' => '2024-10-17 15:44:41',
            'modified' => '2024-10-17 15:44:41',
        ];

        $this->post('/ConsultasEstados/add', $data);
        $this->assertResponseSuccess();
    }

    public function testAddFailure()
    {

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        // Simulamos una solicitud POST con datos válidos
        $data =  [
            'id' => 3,
            'nombre' => '',
            'descripcion' => 'nuevo estado',
            'activo' => 1,
            'created' => '2024-10-17 15:44:41',
            'modified' => '2024-10-17 15:44:41',
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post('/ConsultasEstados/add', $data);
        $this->assertResponseSuccess();

        // Verificamos que no se haya guardado ningun estado
        $consultas_estados = $this->getTableLocator()->get('ConsultasEstados');
        $consulta_estado = $consultas_estados->find()->where(['descripcion' => 'nuevo estado'])->first();

        $this->assertEmpty($consulta_estado);
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\ConsultasEstadosController::edit()
     */

    public function testEdit(): void
    {
        // ID de una categoría existente
        $consultaEstadoId = 1;

        // Datos de actualización para la categoría
        $data = [
            'id' => 1,
            'nombre' => 'PENDIENTE',
            'descripcion' => 'se cambio la descripcion',
            'activo' => 1,
            'created' => '2024-10-17 15:44:41',
            'modified' => '2024-10-17 15:44:41',
        ];

        // Simula la petición POST/PATCH a la acción edit con los datos de actualización
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/ConsultasEstados/edit/{$consultaEstadoId}", $data);

        // Verifica que hubo una redirección a la página de índice o a otra URL especificada
        $this->assertResponseCode(302);
        //$this->assertRedirect(['controller' => 'Categorias', 'action' => 'index']);

        // Carga la categoría de la base de datos y verifica los cambios
        $consultas_estados = $this->getTableLocator()->get('ConsultasEstados');
        $consulta_estado = $consultas_estados->get($consultaEstadoId);

       $this->assertEquals('se cambio la descripcion', $consulta_estado->descripcion);
    }


    public function testEditFailure(): void
    {
        // ID de un estado existente
        $consultaEstadoId = 1;

        // Datos de actualización para el proveedor con nombre vacio
        $data = [
            'id' => 1,
            'nombre' => '',
            'descripcion' => 'se cambio la descripcion',
            'activo' => 1,
            'created' => '2024-10-17 15:44:41',
            'modified' => '2024-10-17 15:44:41',
        ];

        // Simula la petición POST/PATCH a la acción edit con los datos de actualización
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/ConsultasEstados/edit/{$consultaEstadoId}", $data);

        // Verificamos que no se haya guardado ningun proveedor
        $consultas_estados = $this->getTableLocator()->get('ConsultasEstados');
        $consulta_estado = $consultas_estados->find()->where(['descripcion' => 'se cambio la descripcion'])->first();

        $this->assertEmpty($consulta_estado);
    }


    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\ConsultasEstadosController::delete()
     */
    public function testDelete(): void
    {
        // ID de una categoría existente que se va a eliminar
        $consultaEstadoId = 3;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/ConsultasEstados/delete/{$consultaEstadoId}");


        // Verifica que hubo una redirección después de eliminar
        $this->assertResponseCode(302);


        // Carga la categoría desde la base de datos para verificar que se ha eliminado
        $consultas_estados = $this->getTableLocator()->get('ConsultasEstados');
        $consulta_estado = $consultas_estados->find()->where(['id' => $consultaEstadoId])->first();

        $this->assertNull($consulta_estado, 'El estado de consulta no pudo ser eliminado.');
    }

    /**
     * Test delete failure method
     * Intenta borrar consulta estado con consulta asociada
     *
     * @return void
     * @uses \App\Controller\ConsultasEstadosController::delete()
     */
    public function testDeleteFailure(): void
    {
        // ID de una categoría existente que se va a eliminar
        $consultaEstadoId = 2;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/ConsultasEstados/delete/{$consultaEstadoId}");

        // Verifica que hubo una redirección después de eliminar
        $this->assertResponseCode(302);

        // Carga la categoría desde la base de datos para verificar que se ha eliminado
        $consultas_estados = $this->getTableLocator()->get('ConsultasEstados');
        $consulta_estado = $consultas_estados->find()->where(['id' => $consultaEstadoId])->first();

        $this->assertNotNull($consulta_estado, 'El estado de consulta no pudo ser eliminado.');
    }

    public function testGetConditions()
    {

        $this->enableCsrfToken();
        $this->enableSecurityToken();;

        // Simula una consulta de request con datos
        $this->get('/ConsultasEstados/index?nombre=test&activo=1'); // Cambia la URL según sea necesario
        $this->assertResponseOk();


        // Opcional: puedes acceder a la variable set en la respuesta
        $data =  $this->_controller->getRequest()->getQuery();

        if (isset($data['nombre']) and !empty($data['nombre'])) {
            $conditions['where'][] = ['ConsultasEstados.nombre LIKE' => '%' . $data['nombre'] . '%'];
        }

        if (isset($data['activo']) and !empty($data['activo'])) {
            $conditions['where'][] = ['ConsultasEstados.activo' => $data['activo']];
        }

        // Verifica las condiciones
        $this->assertEquals([
            'where' => [
                ['ConsultasEstados.nombre LIKE' => '%test%'],
                ['ConsultasEstados.activo' => '1']
            ]
        ], $conditions);
    }
}
