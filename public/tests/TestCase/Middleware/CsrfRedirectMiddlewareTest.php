<?php
declare(strict_types=1);

namespace App\Test\TestCase\Middleware;

use App\Middleware\CsrfRedirectMiddleware;
use Cake\Http\Exception\InvalidCsrfTokenException;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Test case for CsrfRedirectMiddleware
 */
class CsrfRedirectMiddlewareTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Middleware\CsrfRedirectMiddleware
     */
    protected CsrfRedirectMiddleware $middleware;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new CsrfRedirectMiddleware();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->middleware);

        parent::tearDown();
    }

    /**
     * Test process method when no InvalidCsrfTokenException is thrown
     *
     * @return void
     */
    public function testProcessWithoutException(): void
    {
        // Simular un request y un handler
        $request = new ServerRequest();
        $response = new Response();
        $handler = $this->createMock(RequestHandlerInterface::class);

        // Simular que el handler devuelve una respuesta normal
        $handler->expects($this->once())
            ->method('handle')
            ->with($request)
            ->willReturn($response);

        // Verificar que la respuesta del middleware es la misma que devuelve el handler
        $result = $this->middleware->process($request, $handler);
        $this->assertSame($response, $result);
    }

    /**
     * Test process method when InvalidCsrfTokenException is thrown
     *
     * @return void
     */
    public function testProcessWithInvalidCsrfTokenException(): void
    {
        // Simular un request y un handler
        $request = new ServerRequest();
        $handler = $this->createMock(RequestHandlerInterface::class);

        // Simular que el handler lanza una InvalidCsrfTokenException
        $handler->expects($this->once())
            ->method('handle')
            ->with($request)
            ->will($this->throwException(new InvalidCsrfTokenException()));

        // Ejecutar el middleware
        $result = $this->middleware->process($request, $handler);

        // Verificar que la respuesta es una redirección al login con código 302
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertEquals(302, $result->getStatusCode());
        $this->assertEquals('/login', $result->getHeaderLine('Location'));
    }
}
