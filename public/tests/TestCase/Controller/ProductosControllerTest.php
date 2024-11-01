<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ProductosController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ProductosController Test Case
 *
 * @uses \App\Controller\ProductosController
 */
class ProductosControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Productos',
        'app.Categorias',
        'app.Proveedores',
        'app.ProductosArchivos',
        'app.ProductosPrecios',
        'app.DetallesPedidos',
        'app.Direcciones',
        'app.Localidades'
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
                'direccion' => [
                    'id' => 1,
                    'calle' => 'padilla',
                    'numero' => '752',
                    'piso' => '2',
                    'departamento' => 'a',
                    'localidad_id' => 1,
                    'localidade' => [
                        'id' => 1,
                        'provincia_id' => 1,
                        'nombre' => 'Buenos Aires'
                    ]

                ]
            ],
            'RbacAcciones' => [
                'Productos' => [
                    'index' => 1,
                    'add' => 1,
                    'view' => 1,
                    'delete' => 1,
                    'detail' => 1
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
     * @uses \App\Controller\ProductosController::index()
     */
    public function testIndex(): void
    {
        $this->get('/Productos');

        $this->assertResponseOk();
        $filters = $this->viewVariable('filters');
        $this->assertNotNull($filters, 'Los filtros no fueron cargados correctamente.');
        $productos = $this->viewVariable('productos');

        $this->assertNotEmpty($productos, 'No se cargaron consultas en la vista.');
    }

    /**
     * Test detail method
     *
     * @return void
     * @uses \App\Controller\ProductosController::detail()
     */
    public function testDetailProductoExistente()
    {
        // Configurar un ID válido para un producto que exista en tus fixtures
        $id = 1;

        $this->get("/productos/detail/$id");
        $this->assertResponseOk();
        // Verificar que el producto y las provincias se pasaron a la vista
        $this->assertResponseContains('producto');
    }

    public function testDetailProductoNoExistente()
    {
        // Configurar un ID no existente
        $id = 99999;

        // Ejecutar la acción
        $this->get("/productos/detail/$id");

        // Verificar mensaje de error
        $this->assertSession('El producto no existe.', 'Flash.flash.0.message');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\ProductosController::add()
     */
    public function testAdd(): void
    {
        $data =  [
            'nombre' => 'K-MOD',
            'categoria_id' => 1,
            'proveedor_id' => 1,
            'descripcion_breve' => 'zarazaaaa',
            'descripcion_larga' => 'zarazan zarazan zarazan.',
            'stock' => 1,
            'created' => '2024-10-17 15:44:47',
            'modified' => '2024-10-17 15:44:47',
            'activo' => 1,
            'productos_precios' =>
            [
                0 => [
                    'precio' => 250000.00,
                    'fecha_desde' => '2024-10-17 15:44:50',
                ]
            ],
            'imagenes' => [
                // Simula archivos de imagen
                ['file_name' => 'file1.jpg', 'file_extension' => 'jpg', 'file_size' => 12345, 'file_path' => 'img/productos/file1.jpg'],
                ['file_name' => 'file2.jpg', 'file_extension' => 'jpg', 'file_size' => 12345, 'file_path' => 'img/productos/file2.jpg']
            ],
        ];

        // Crear el mock del componente Upload y envolverlo en un Closure
        $this->mockService(
            \App\Controller\Component\UploadComponent::class,
            function () {
                $uploadMock = $this->createMock(\App\Controller\Component\UploadComponent::class);
                $uploadMock->method('uploadMultiple')
                    ->willReturn([
                        'status' => true,
                        'files' => [
                            ['file_name' => 'file1.jpg', 'file_extension' => 'jpg', 'file_size' => 12345, 'file_path' => 'img/productos/file1.jpg'],
                            ['file_name' => 'file2.jpg', 'file_extension' => 'jpg', 'file_size' => 12345, 'file_path' => 'img/productos/file2.jpg']
                        ]
                    ]);
                return $uploadMock;
            }
        );

        $this->enableCsrfToken();
        $this->enableSecurityToken();


        $this->post('/Productos/add', $data);

        // Verificar que la respuesta sea una redirección
        $this->assertResponseSuccess();

        $productos = $this->getTableLocator()->get('Productos')->find()->all();
        $nuevaProducto = $productos->last();
        $this->assertEquals('K-MOD', $nuevaProducto->nombre);
    }

    public function testAddFailure(): void
    {
        $data =  [
            'nombre' => '', // Campo vacío para forzar un error de validación
            'categoria_id' => 1,
            'proveedor_id' => 1,
            'descripcion_breve' => 'zarazaaaa',
            'descripcion_larga' => 'zarazan zarazan zarazan.',
            'stock' => 1,
            'created' => '2024-10-17 15:44:47',
            'modified' => '2024-10-17 15:44:47',
            'activo' => 1,
            'productos_precios' =>
            [
                0 => [
                    'precio' => 250000.00,
                    'fecha_desde' => '2024-10-17 15:44:50',
                ]
            ],

        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();


        $this->post('/Productos/add', $data);

        // Verificar que la respuesta sea una redirección
        $this->assertResponseSuccess();
        $this->assertNoRedirect();  // Asegura que no haya redirección en caso de error

        // Verificar que contiene un mensaje de error de validación para 'nombre'
        $this->assertResponseContains('El campo nombre no puede estar vacío.');
    }


    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\ProductosController::edit()
     */
    public function testEdit(): void
    {

        $productoId = 2;
        //Cambio el precio
        $data =  [
            'id' => 2,
            'nombre' => 'K-MOD2',
            'categoria_id' => 1,
            'proveedor_id' => 1,
            'descripcion_breve' => 'zarazaaaa',
            'descripcion_larga' => 'zarazan zarazan zarazan.',
            'stock' => 1,
            'created' => '2024-10-17 15:44:47',
            'modified' => '2024-10-17 15:44:47',
            'activo' => 1,
            'productos_precios' =>
            [
                0 => [
                    'precio' => 350000.00,
                ]
            ],
            'imagenes' => [
                // Simula archivos de imagen
                ['file_name' => 'file1.jpg', 'file_extension' => 'jpg', 'file_size' => 12345, 'file_path' => 'img/productos/file1.jpg'],
                ['file_name' => 'file2.jpg', 'file_extension' => 'jpg', 'file_size' => 12345, 'file_path' => 'img/productos/file2.jpg']
            ],
        ];

        // Crear el mock del componente Upload y envolverlo en un Closure
        $this->mockService(
            \App\Controller\Component\UploadComponent::class,
            function () {
                $uploadMock = $this->createMock(\App\Controller\Component\UploadComponent::class);
                $uploadMock->method('uploadMultiple')
                    ->willReturn([
                        'status' => true,
                        'files' => [
                            ['file_name' => 'file1.jpg', 'file_extension' => 'jpg', 'file_size' => 12345, 'file_path' => 'img/productos/file1.jpg'],
                            ['file_name' => 'file2.jpg', 'file_extension' => 'jpg', 'file_size' => 12345, 'file_path' => 'img/productos/file2.jpg']
                        ]
                    ]);
                return $uploadMock;
            }
        );

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post("/Productos/edit/{$productoId}", $data);

        // Verificar que la respuesta sea una redirección
        $this->assertResponseCode(302);

        // Carga el producto de la base de datos y verifica los cambios
        $productos = $this->getTableLocator()->get('Productos');
        $producto = $productos->get($productoId);

        $this->assertEquals('K-MOD2', $producto->nombre);
    }


    public function testEditFailure(): void
    {

        $productoId = 2;

        $data =  [
            'id' => 2,
            'nombre' => '',

            'descripcion_breve' => 'zarazaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaasdfasdfdsafdfsdfasfdasfdsafasdfsfdasfdasfdsafdsafdsdafasfsafasfsafdasfsafdasfdsafdsafasfasfsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'descripcion_larga' => 'zarazan zarazan zarazan.',
            'stock' => 1,
            'created' => '2024-10-17 15:44:47',
            'modified' => '2024-10-17 15:44:47',
            'activo' => 1,
            'productos_precios' =>
            [
                0 => [
                    'precio' => "asdfasdf",
                    'fecha_desde' => '2024-10-17 15:44:50',
                ]
            ],

        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post("/Productos/edit/{$productoId}", $data);

        // Verificar que la respuesta sea una redirección
        $this->assertResponseSuccess();
        // $this->assertFlashMessage('El producto no existe.');
    }

    public function testEditNotExist(): void
    {

        $productoId = 999;

        $data =  [
            'id' => 999,
            'nombre' => 'TEST',
            'categoria_id' => 1,
            'proveedor_id' => 1,
            'descripcion_breve' => 'zarazaaaa',
            'descripcion_larga' => 'zarazan zarazan zarazan.',
            'stock' => 1,
            'created' => '2024-10-17 15:44:47',
            'modified' => '2024-10-17 15:44:47',
            'activo' => 1,
            'productos_precios' =>
            [
                0 => [
                    'precio' => 250000.00,
                    'fecha_desde' => '2024-10-17 15:44:50',
                ]
            ],
            'imagenes' => [
                // Simula archivos de imagen
                ['file_name' => 'file1.jpg', 'file_extension' => 'jpg', 'file_size' => 12345, 'file_path' => 'img/productos/file1.jpg'],
                ['file_name' => 'file2.jpg', 'file_extension' => 'jpg', 'file_size' => 12345, 'file_path' => 'img/productos/file2.jpg']
            ],
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post("/Productos/edit/{$productoId}", $data);

        // Verificar que la respuesta sea una redirección
        $this->assertResponseSuccess();
        $this->assertFlashMessage('El producto no existe.');
    }

    public function testEditBadArgument(): void
    {
        //producto no válida
        $this->get('/productos/edit/test');
        // Verificar que redirige debido a un argumento no válido        
        $this->assertResponseCode(302);

        // Opcional: Verificar un mensaje de error por argumento inválido
        $this->assertFlashMessage('El producto no es válido.');
    }


    /**
     * Test stock method
     *
     * @return void
     * @uses \App\Controller\ProductosController::stock()
     */
    public function testStockProducto(): void
    {
        // Caso de éxito: producto existente
        $productoId = 1; // Asume que existe un producto con este ID en los datos de prueba
        $this->get("/Productos/stock/{$productoId}");

        // Verifica que la respuesta sea JSON
        $this->assertContentType('application/json');
        $this->assertResponseOk();

        // Verifica que el JSON contiene los datos esperados
        $responseData = json_decode((string)$this->_response->getBody(), true);
        $this->assertArrayHasKey('id', $responseData);
        $this->assertArrayHasKey('stock', $responseData);
        $this->assertEquals($productoId, $responseData['id']);
    }





    /**
     * Test catalogoCliente method
     *
     * @return void
     * @uses \App\Controller\ProductosController::catalogoCliente()
     */
    public function testCatalogoClienteSuccess()
    {
        $this->get('/productos/catalogoCliente?search=K');

        $this->assertResponseSuccess();

        $productos = $this->viewVariable('productos');

        $this->assertNotEmpty($productos, 'La lista de productos debería contener elementos');

        // Puedes agregar una comprobación específica para los productos y sus relaciones
        foreach ($productos as $producto) {
            $this->assertNotEmpty($producto->categoria, 'Cada producto debería tener una categoría asociada');
            $this->assertNotEmpty($producto->productos_archivos, 'Cada producto debería tener archivos asociados');
            $this->assertNotEmpty($producto->productos_precios, 'Cada producto debería tener al menos un precio asociado');
        }
    }

    /**
     * Test catalogoClienteCategorias method
     *
     * @return void
     * @uses \App\Controller\ProductosController::catalogoClienteCategorias()
     */
    public function testCatalogoClienteCategorias(): void
    {
        $this->get('/productos/catalogoClienteCategorias/1');

        $this->assertResponseSuccess();

        $productos = $this->viewVariable('productos');

        $this->assertNotEmpty($productos, 'La lista de productos debería contener elementos');

        // Puedes agregar una comprobación específica para los productos y sus relaciones
        foreach ($productos as $producto) {
            $this->assertNotEmpty($producto->categoria, 'Cada producto debería tener una categoría asociada');
            $this->assertNotEmpty($producto->productos_archivos, 'Cada producto debería tener archivos asociados');
            $this->assertNotEmpty($producto->productos_precios, 'Cada producto debería tener al menos un precio asociado');
        }
    }

    public function testCatalogoClienteCategoriasNotExist(): void
    {
        $this->get('/productos/catalogoClienteCategorias/99');

        // Verificar que redirige debido a una categoría no existente        
        $this->assertResponseCode(302);

        // Opcional: Verificar un mensaje de error
        $this->assertFlashMessage('La categoría no existe.');
    }

    public function testCatalogoClienteCategoriasBadArgument(): void
    {
        //categoría no válida
        $this->get('/productos/catalogoClienteCategorias/test');
        // Verificar que redirige debido a un argumento no válido        
        $this->assertResponseCode(302);

        // Opcional: Verificar un mensaje de error por argumento inválido
        $this->assertFlashMessage('La categoría no es válida.');
    }

    /**
     * Test delete method
     *
     * Prueba el método delete para verificar que un tipo de documento se elimina correctamente
     * @return void
     * @uses \App\Controller\ProductosController::delete()
     */
    public function testDelete(): void
    {
        $productoId = 2;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Productos/delete/{$productoId}");

        // Verifica que hubo una redirección después de eliminar
        $this->assertResponseCode(302);
        
    }

    public function testDeleteNotExist(): void
    {
        $productoId = 99;

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Productos/delete/{$productoId}");

        // Verifica que hubo una redirección después de eliminar
        $this->assertResponseCode(302);

        
    }

    public function testDeleteBadArgument(): void
    {
        $productoId = "test";

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post("/Productos/delete/{$productoId}");

        // Verifica que hubo una redirección después de eliminar
        $this->assertResponseCode(302);
        
    }
}
