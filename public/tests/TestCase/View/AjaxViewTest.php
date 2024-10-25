<?php
declare(strict_types=1);

namespace App\Test\TestCase\View;

use App\View\AjaxView;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;

/**
 * Test case for AjaxView
 */
class AjaxViewTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\AjaxView
     */
    protected $AjaxView;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Simula una petición y una respuesta
        $request = new ServerRequest();
        $response = new Response();

        // Instancia la vista AjaxView
        $this->AjaxView = new AjaxView($request, $response);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AjaxView);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        // Verifica que el layout es 'ajax'
        $this->assertEquals('ajax', $this->AjaxView->getLayout());

        // Verifica que el tipo de respuesta sea 'text/html'
        $this->assertEquals('text/html', $this->AjaxView->getResponse()->getType());
    }
}
