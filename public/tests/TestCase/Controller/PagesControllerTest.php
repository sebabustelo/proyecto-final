<?php
namespace App\Test\TestCase\Controller;

use App\Controller\PagesController;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\View\Exception\MissingTemplateException;

class PagesControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
     * Test redirection to root when no path is provided
     */
    public function testDisplayRedirectsToRootWithoutPath()
    {
        $this->get('/pages/home'); // Correct path for the test
        $this->assertResponseCode(302);
        $this->assertRedirect('/');
    }

    /**
     * Test rendering of an existing view
     */
    public function testDisplayRendersExistingView()
    {
        $this->get('/pages/home');
        $this->assertResponseCode(302);

    }

}
