<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Route\InflectedRoute;

return function (RouteBuilder $routes): void {
    // Usa InflectedRoute para transformar nombres automáticamente (recomendado)
    $routes->setRouteClass(InflectedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        // Ruta base, redirige a login
        $builder->connect('/', ['plugin' => 'Rbac', 'controller' => 'RbacUsuarios', 'action' => 'login']);

        // Rutas específicas de plugins
        $builder->connect('/db/index', ['plugin' => 'Db', 'controller' => 'Db', 'action' => 'index']);
        $builder->connect('/db/index/*', ['plugin' => 'Db', 'controller' => 'Db', 'action' => 'index']);
        $builder->connect('/rbac/{controller}/{action}/*', ['plugin' => 'Rbac']);
        $builder->connect('/db/{controller}/{action}/*', ['plugin' => 'Db']);

        // Rutas de autenticación y gestión de usuarios en Rbac
        $builder->connect('/login', ['plugin' => 'Rbac', 'controller' => 'RbacUsuarios', 'action' => 'login']);
        $builder->connect('/register', ['plugin' => 'Rbac', 'controller' => 'RbacUsuarios', 'action' => 'register']);
        $builder->connect('/registerPassword/*', ['plugin' => 'Rbac', 'controller' => 'RbacUsuarios', 'action' => 'registerPassword']);
        $builder->connect('/forgetPassword/*', ['plugin' => 'Rbac', 'controller' => 'RbacUsuarios', 'action' => 'forgetPassword']);
        $builder->connect('/changePassword/*', ['plugin' => 'Rbac', 'controller' => 'RbacUsuarios', 'action' => 'changePassword']);
        $builder->connect('/editMyUser', ['plugin' => 'Rbac', 'controller' => 'RbacUsuarios', 'action' => 'editMyUser']);
        $builder->connect('/details/*', ['plugin' => 'Rbac', 'controller' => 'RbacUsuarios', 'action' => 'detail']);

        // Ruta de páginas predeterminada
        $builder->connect('/pages/*', 'Pages::display');

        // Rutas de controladores genéricos con método index
        $builder->connect('/rbac/:controller', ['plugin' => 'Rbac', 'action' => 'index']);

        // Ruta global para todos los controladores y acciones con parámetros (opcional)
        $builder->connect('/{controller}/{action}/*');

        // Rutas de fallback para controladores y métodos
        $builder->fallbacks(InflectedRoute::class);
    });
};
