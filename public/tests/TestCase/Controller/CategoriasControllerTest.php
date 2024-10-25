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

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\CategoriasController::index()
     */
    public function testIndex(): void
    {
        // Simular sesión con un usuario logueado y permisos
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
                    'index' => 1,  // Tiene permiso para 'index' en 'Categorias'
                ],
            ],
        ]);

        // Simula una solicitud GET a la acción 'index' del controlador CategoriasController
        $this->get('/categorias');

        // Verifica que la respuesta sea exitosa (código HTTP 200)
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

    public function testIndexSinPermisos(): void
    {
        // Simular sesión con un usuario logueado pero sin permisos para 'index'
        $this->session([
            'RbacUsuario' => [
                'id' => 1,
                'perfil_id' => 1,
                'usuario' => 'usuario_test',
            ],
            'RbacAcciones' => [
                'Categorias' => [
                    'index' => 0,  // Tiene permiso para 'index' en 'Categorias'
                ],
                'RbacUsuarios' => [
                    'login' => 1
                ]
            ],
        ]);

        // Realiza la solicitud GET a la acción 'index' del controlador CategoriasController
        $this->get('/categorias');

        // Verifica que la respuesta es una redirección
        //$this->assertRedirect('/rbac/rbacUsuarios/login');

        // Verifica que el mensaje de error de permisos se haya mostrado
        $this->assertFlashMessage('Usted no tiene permiso para acceder a la funcionalidad requerida.');
    }




    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\CategoriasController::add()
     */
    public function testAddSuccess()
    {
        $this->session([
            'RbacUsuario' => [
                'id' => 1,
                'perfil_id' => 1,
                'usuario' => 'usuario_test',
            ],
            'RbacAcciones' => [
                'Categorias' => [
                    'index' => 1,
                    'add' => 1,
                ],
                'RbacUsuarios' => [
                    'login' => 1
                ]
            ],
        ]);

        // Simulamos una solicitud GET para establecer el token CSRF
        $this->get('/categorias/add');
        // Verificamos que la respuesta sea exitosa
        $this->assertResponseOk();

        // Obtener el token CSRF desde la respuesta de la solicitud
        $csrfToken = $_SESSION['csrfToken'];

        // Simulamos una solicitud POST con datos válidos
        $data = [
            'nombre' => 'Rodilla',
            'descripcion' => 'set para rodilla',
            'created' => '2024-10-17 15:44:36',
            'modified' => '2024-10-17 15:44:36',
            'activo' => 1,
            'csrf' => $_SESSION['csrfToken']
        ];

        // Ejecutamos la solicitud POST
        $this->post('/categorias/add', $data);

        // Verificamos que la respuesta sea una redirección al index
        $this->assertResponseSuccess();
        //$this->assertRedirect(['controller' => 'Categorias', 'action' => 'index']); // Verifica que se redirige a index


    }



    public function testAddFailure()
    {
        // Simulamos una solicitud POST con datos inválidos (por ejemplo, nombre vacío)
        $data = [
            'nombre' => '', // Nombre vacío debería fallar
            'descripcion' => 'Descripción sin nombre',

        ];

        // Ejecutamos la solicitud POST
        $this->post('/categorias/add', $data);

        // Verificamos que no se redirige
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


    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\CategoriasController::delete()
     */
    public function testDelete(): void
    {
        // ID de una categoría existente que se va a eliminar
        $categoriaId = 2;

        // Simula la petición POST/DELETE para eliminar la categoría
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/categorias/delete/{$categoriaId}");


        // Verifica que hubo una redirección después de eliminar
        $this->assertResponseCode(302);
        $this->assertFlashMessage('La categoría ha sido eliminada.');
        //$this->assertRedirect(['controller' => 'Categorias', 'action' => 'index']);

        // Carga la categoría desde la base de datos para verificar que se ha eliminado
        $categorias = $this->getTableLocator()->get('Categorias');
        $categoria = $categorias->find()->where(['id' => $categoriaId])->first();


        $this->assertNull($categoria, 'La categoría no fue eliminada correctamente.');
    }

     /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\CategoriasController::delete()
     */
    // public function testDeleteExist(): void
    // {
    //     // ID de una categoría existente que se va a eliminar
    //     $categoriaId = 1;



    //     // Simula la petición POST/DELETE para eliminar la categoría
    //     $this->enableCsrfToken();
    //     $this->enableSecurityToken();
    //     $this->post("/categorias/delete/{$categoriaId}");


    //     // Verifica que hubo una redirección después de eliminar
    //     $this->assertResponseCode(302);
    //     $this->assertFlashMessage('La categoría ha sido eliminada.');
    //     //$this->assertRedirect(['controller' => 'Categorias', 'action' => 'index']);

    //     // Carga la categoría desde la base de datos para verificar que se ha eliminado
    //     $categorias = $this->getTableLocator()->get('Categorias');
    //     $categoria = $categorias->find()->where(['id' => $categoriaId])->first();


    //     $this->assertNull($categoria, 'La categoría no fue eliminada correctamente.');
    // }

    public function testDeleteFailure(): void
    {
        // ID de una categoría inexistente
        $categoriaId = 9999;


        // Simula la petición POST/DELETE para eliminar la categoría
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/categorias/delete/{$categoriaId}");


        // Verifica que hubo una redirección al intentar eliminar una categoría inexistente
        $this->assertResponseCode(404);
       // $this->assertRedirect(['controller' => 'Categorias', 'action' => 'index']);

        // Verifica que el mensaje de error de eliminación fallida se haya mostrado
        $this->assertFlashMessage('No se pudo eliminar la categoría. Por favor, inténtalo de nuevo.');
    }
}
