<?php

namespace App\Test\TestCase\Controller;

use App\Controller\PedidosController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class PedidosControllerTest extends TestCase
{
    use IntegrationTestTrait;

    public function setUp(): void
    {
        parent::setUp();
        // Cargar los fixtures necesarios, por ejemplo, usuarios y roles
       // $this->loadFixtures('Users', 'Roles', 'Permissions');
    }

    // Método para simular el inicio de sesión
    protected function logIn()
    {
        // Crea un usuario con los permisos necesarios
        $this->post('/login', [
            'usuario' => 'sebabustelo',
            'password' => 'Sebastian*',
        ]);
        // Verifica que el usuario ha sido autenticado
        $this->assertResponseSuccess();
    }

    public function testAddForCliente()
    {
        // Simular el inicio de sesión
        $this->logIn();

        // Realizar la petición a la acción que requiere login
        $this->post('/pedidos/addForCliente', [
            'producto_id' => 1,
            'cantidad' => 2,
            'orden_medica' => 'ruta/a/orden_medica.pdf',
        ]);

        // Verifica que la respuesta sea exitosa
        $this->assertResponseSuccess();
        // Puedes agregar más aserciones según lo que esperes que suceda
    }
}
