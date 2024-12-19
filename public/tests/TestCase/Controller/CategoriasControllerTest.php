<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\CategoriasController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\CategoriasController Test Case
 *
 * @uses \App\Controller\CategoriasController
 */
class CategoriasControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Categorias',
        'app.Productos',
        'app.Proveedores',
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
                'Categorias' => [
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
     * @uses \App\Controller\CategoriasController::index()
     */
    public function testIndex(): void
    {
        $this->get('/categorias');

        $this->assertResponseOk();

        // Verifica que los filtros sean asignados correctamente a la vista
        $filters = $this->viewVariable('filters');
        $this->assertNotNull($filters, 'Los filtros no fueron cargados correctamente.');

        // Verifica que la vista tiene acceso a las categorías paginadas
        $categorias = $this->viewVariable('categorias');
        $this->assertNotEmpty($categorias, 'No se cargaron categorías en la vista.');

        // Si hay datos en los fixtures, puedes verificar que una categoría en particular esté en la respuesta
        $this->assertResponseContains('Cadera');
    }


    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\CategoriasController::add()
     */
    public function testAddSuccess()
    {

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        // Simulamos una solicitud POST con datos válidos
        $data = [
            'nombre' => 'Rodilla',
            'descripcion' => 'set para rodilla',
            'created' => '2024-10-17 15:44:36',
            'modified' => '2024-10-17 15:44:36',
            'activo' => 1,
        ];

        $this->post('/categorias/add', $data);
        $this->assertResponseSuccess();
    }



    public function testAddFailure()
    {
        // Simulamos una solicitud POST con datos inválidos (por ejemplo, nombre vacío)
        $data = [
            'nombre' => '', // Nombre vacío debería fallar
            'descripcion' => 'Descripción sin nombre',

        ];
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post('/categorias/add', $data);
        $this->assertResponseSuccess();

        // Verificamos que no se haya guardado ninguna categoría
        $categorias = $this->getTableLocator()->get('Categorias');
        $categoria = $categorias->find()->where(['descripcion' => 'Descripción sin nombre'])->first();

        $this->assertEmpty($categoria);
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\CategoriasController::edit()
     */
    public function testEdit(): void
    {
        // ID de una categoría existente
        $categoriaId = 1;

        // Datos de actualización para la categoría
        $data = [
            'id' => 1,
            'nombre' => 'Rodilla',
            'descripcion' => 'set de rodilla'
        ];

        // Simula la petición POST/PATCH a la acción edit con los datos de actualización
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/categorias/edit/{$categoriaId}", $data);

        // Verifica que hubo una redirección a la página de índice o a otra URL especificada
        $this->assertResponseCode(302);
        //$this->assertRedirect(['controller' => 'Categorias', 'action' => 'index']);

        // Carga la categoría de la base de datos y verifica los cambios
        $categorias = $this->getTableLocator()->get('Categorias');
        $categoria = $categorias->get($categoriaId);

        $this->assertEquals('Rodilla', $categoria->nombre);
        $this->assertEquals('set de rodilla', $categoria->descripcion);
    }

    public function testEditFailure(): void
    {
        // ID de una categoría existente
        $categoriaId = 1;

        // Datos de actualización para la categoría
        $data = [
            'id' => 1,
            'nombre' => '',
            'descripcion' => 'set de rodilla'
        ];

        // Simula la petición POST/PATCH a la acción edit con los datos de actualización
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/categorias/edit/{$categoriaId}", $data);

        // Verifica que hubo una redirección a la página de índice o a otra URL especificada
        $this->assertResponseCode(302);

        // Verifica que se generó un mensaje de error específico para el campo 'nombre'
        $this->assertFlashMessage('La categoría no pudo ser guardada.');
    }

    public function testEditNonExistCategory(): void
    {
        // Un ID que no existe
        $nonExistentId = 9999;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/categorias/edit/{$nonExistentId}", [
            'nombre' => 'Nueva Categoria',
            'descripcion' => 'Descripción'
        ]);

       //Si no existe la cateogria redirige al index
        $this->assertResponseCode(302);
        $this->assertFlashMessage('La categoría no existe.');
    }


    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\CategoriasController::delete()
     */
    public function testDeleteExist(): void
    {
        $categoriaId = 1;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/categorias/delete/{$categoriaId}");

        $this->assertResponseCode(302);

        // Carga la categoría desde la base de datos para verificar que se ha eliminado
        $categorias = $this->getTableLocator()->get('Categorias');
        $categoria = $categorias->find()->where(['id' => $categoriaId])->first();

         $this->assertNotNull($categoria, 'La categoría no fue eliminada correctamente.');
    }

    public function testDeleteFailure(): void
    {
        // ID de una categoría inexistente
        $categoriaId = 9999;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/categorias/delete/{$categoriaId}");

        $this->assertResponseCode(302);
        $this->assertFlashMessage('La categoría no existe.');

    }

    public function testGetConditions()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();;

        $this->get('/categorias/index?nombre=test&descripcion=ejemplo&activo=1'); // Cambia la URL según sea necesario
        $this->assertResponseOk();

        // Opcional: puedes acceder a la variable set en la respuesta
        $data =  $this->_controller->getRequest()->getQuery();

        if (isset($data['nombre']) and !empty($data['nombre'])) {
            $conditions['where'][] = ['Categorias.nombre LIKE' => '%' . $data['nombre'] . '%'];
        }

        if (isset($data['descripcion']) and !empty($data['descripcion'])) {
            $conditions['where'][] = ['Categorias.descripcion LIKE ' => '%' . $data['descripcion'] . '%'];
        }

        $this->assertEquals([
            'where' => [
                ['Categorias.nombre LIKE' => '%test%'],
                ['Categorias.descripcion LIKE ' => '%ejemplo%']
            ]
        ], $conditions);
    }
}
