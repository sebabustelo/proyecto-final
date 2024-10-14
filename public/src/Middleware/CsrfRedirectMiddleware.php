<?php
namespace App\Middleware;

use Cake\Http\Exception\InvalidCsrfTokenException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CsrfRedirectMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            // Procesar la solicitud normalmente
            return $handler->handle($request);
        } catch (InvalidCsrfTokenException $e) {
            // Redirigir al login si el token CSRF no es válido
            return (new \Cake\Http\Response())
                ->withStatus(302)
                ->withHeader('Location', '/login');
        }
    }
}
