<?php
declare(strict_types=1);

namespace App\Test\TestCase\View;

use App\View\AjaxView;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;

class AjaxViewTest extends TestCase
{
    public function testInitialization()
    {
        // Crear un request y un response simulados para la prueba
        $request = new ServerRequest();
        $response = new Response();

        // Instanciar la vista AjaxView
        $ajaxView = new AjaxView($request, $response);

        // Verificar que el layout es el esperado
        $this->assertSame('ajax', $ajaxView->getLayout());

        // Verificar que el tipo de respuesta se ha configurado correctamente como 'ajax'
       // $this->assertSame('ajax', $ajaxView->getResponse()->getType());
    }
}
