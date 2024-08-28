<?php

namespace Rbac\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\App;
use Cake\Core\Plugin;
use Controller;

class ControllerListComponent extends Component
{

    /**
     * Return an array of user Controllers and their methods.
     * The function will exclude ApplicationController methods
     * @return array
     */

    public function getControllers()
    {
        $files = scandir('../src/Controller/');
        $plugins =  scandir('../plugins/');
        $results = [];
        $ignoreList = [
            '.',
            '..',
            'Component',
            'AppController.php',
        ];

        foreach ($plugins as $plugin) {
            //$isLoaded = Plugin::isLoaded($plugin);            
            if (!in_array($plugin, $ignoreList) && $plugin != 'DebugKit' && $plugin != 'AdminLTE') {
                //Search in plugin path
                $files_plugins = scandir('../plugins/' . $plugin . '/src/Controller');

                foreach ($files_plugins as $file_plugin) {
                    if (!in_array($file_plugin, $ignoreList)) {
                        $controller = explode('.', $file_plugin)[0];
                        array_push($results, str_replace('Controller', '', $plugin . "." . $controller));
                    }
                }
            }
        }
        //debug($results);
        foreach ($files as $file) {
            if (!in_array($file, $ignoreList)) {
                $controller = explode('.', $file)[0];
                array_push($results, str_replace('Controller', '', $controller));
            }
        }
        //debug($results);die;
        return $results;
    }

    public function getActions($controllerName)
    {
        $controller = explode('.', $controllerName);
        // debug($controller);

        if (count($controller) > 1) {
            $className = $controller[0] . '\\Controller\\' . $controller[1] . 'Controller';
        } else {
            $className = 'App\\Controller\\' . $controllerName . 'Controller';
        }

        // debug($className);die;
        //$className = 'Rbac\\Controller\\ConfiguracionesController';
        $class = new \ReflectionClass($className);
        //debug($class);
        //die;
        $actions = $class->getMethods(\ReflectionMethod::IS_PUBLIC);

        $results = [$controllerName => []];
        $ignoreList = ['beforeFilter', 'afterFilter', 'initialize', 'beforeRender'];
        foreach ($actions as $action) {
            if ($action->class == $className && !in_array($action->name, $ignoreList)) {
                array_push($results[$controllerName], $action->name);
            }
        }
        return $results;
    }

    public function get($listControlleDB)
    {
        $aCtrlClasses = $this->getControllers();
        $i = 0;
        $controllerAcciones = array();

        foreach ($aCtrlClasses as $controller) {
            //$this->controller = $this->_registry->getController();
            // $sesion = $this->controller->getRequest()->getSession();
            $aMethods = $this->getActions($controller);

            foreach ($aMethods as $idx => $method) {
                if ($method == '_' && $method != '_null') {
                    unset($aMethods[$idx]);
                }
            }

            $controllers[$controller] = $aMethods;

            foreach ($controllers[$controller] as $controllerAccion) {

                for ($n = 0; $n < count($controllerAccion); $n++) {
                    
                    $plugin_controller = explode('.', $controller);

                    if (isset($plugin_controller[1])) {
                        $controllerName = $plugin_controller[1];
                        $plugin = $plugin_controller[0];
                    } else {
                        $plugin = null;
                        $controllerName = $controller;
                    }

                    //Aca cambiar existeEnDB, se debe agregar el plugin por si mas de un plugin tienen acciones con el mismo nombre
                    if (substr($controllerAccion[$n], 0, 2) != '__' && !$this->existeEnDB($plugin, $controllerName, $controllerAccion[$n], $listControlleDB)) {
                        //debug("No existio - " . $controllerAccion[$n]);
                        //debug($plugin . "--" . $controller . "--" . $controllerAccion[$n] . "--");

                        $controllerAcciones[$i]['id'] = '';
                        $controllerAcciones[$i]['plugin'] = $plugin;
                        $controllerAcciones[$i]['controller'] = $controllerName;
                        $controllerAcciones[$i]['action'] = $controllerAccion[$n];
                        $i++;
                    }
                }
            }
        }
        return ($controllerAcciones);
    }

    function existeEnDB($plugin, $controller, $controllerAccion, $listControlleDB)
    {
        $existe = FALSE;
        foreach ($listControlleDB as $value) {

            if ($value['plugin'] == $plugin && $value['controller'] == $controller && $value['action'] == $controllerAccion) {
                /*  debug($value['plugin']);
                debug($value['controller']);
                debug($value['action']);                
                debug($value);
                debug($controller);
                debug(($value['plugin']==$plugin && $value['controller'] == $controller && $value['action'] == $controllerAccion));die;*/
                $existe = TRUE;
                break;
            }
        }
        //debug(($value['plugin'] && $value['controller'] == $controller && $value['action'] == $controllerAccion));die;
        return $existe;
    }
}
