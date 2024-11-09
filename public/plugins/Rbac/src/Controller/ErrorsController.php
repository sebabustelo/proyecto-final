<?php
namespace App\Controller;

namespace Rbac\Controller;

class ErrorsController extends RbacController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('error'); // Puedes usar un layout específico para errores si lo deseas
    }

    // Acción para el error 403 (Acceso Denegado)
    public function error403()
    {
        $this->response = $this->response->withStatus(403);
        $this->set('message', 'Usted no tiene permiso para acceder a esta página.');
        $this->render('error403');
    }

    // Acción para el error 404 (Página No Encontrada)
    public function error404()
    {
        $this->response = $this->response->withStatus(404);
        $this->set('message', 'La página que está buscando no se encuentra.');
        $this->render('error404');
    }

    // Otras acciones para otros errores, como error500()
}
