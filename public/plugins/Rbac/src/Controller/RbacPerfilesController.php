<?php

namespace Rbac\Controller;

use Cake\Http\Exception\MethodNotAllowedException;
use Cake\Http\Exception\InternalErrorException;
use Cake\Utility\Inflector;

class RbacPerfilesController extends RbacController
{

    protected array $paginate = [
        'limit' => 10,
        'order' => [
            'RbacPerfiles.descripcion' => 'asc',
        ],
    ];

    public function index()
    {
        $conditions = $this->getConditions();
        $rbacPerfiles = $this->RbacPerfiles->find()
            ->where($conditions['where'])
            ->contain($conditions['contain']);

        $this->set('rbacPerfiles', $this->paginate($rbacPerfiles));
        $this->set('filters', $this->getRequest()->getQuery());
    }

    public function add()
    {
        $rbacPerfil = $this->RbacPerfiles->newEntity($this->getRequest()->getData(), ['associated' => ['RbacAcciones']]);
        if ($this->getRequest()->is('post')) {
            if ($this->RbacPerfiles->save($rbacPerfil)) {
                $this->Flash->success('Perfil creado correctamente');
                $usuario = $this->getRequest()->getSession()->read('RbacUsuario');
                $this->RbacUsuarios = $this->fetchTable('Rbac.RbacUsuarios');
                $usr = $this->RbacUsuarios
                    ->findByUsuario($usuario['usuario'])
                    ->contain(['RbacPerfiles' => ['RbacAcciones']])->toArray();
                if (isset($usr->rbac_perfiles)) {
                    $this->generarListadoAccionesPorPerfiles($usr->rbac_perfiles);
                }

                return $this->redirect(['plugin' => 'Rbac', 'controller' => 'RbacPerfiles', 'action' => 'index']);
            } else {
                $this->Flash->error('No pudo crear perfil');
            }
        }

        $acciones    = $this->RbacPerfiles->RbacAcciones
            ->find()->select(['RbacAcciones.id', 'RbacAcciones.controller', 'RbacAcciones.action'])
            ->order(['RbacAcciones.controller' => 'ASC', 'RbacAcciones.action' => 'ASC'])
            ->toArray();
        $this->set('acciones', $acciones);
    }

    public function edit($id = null)
    {

        $rbacPerfil = $this->RbacPerfiles
            ->find()
            ->where(['id' => $id])
            ->contain(['RbacAcciones' => [
                'sort' => [
                    //'RbacAcciones.plugin' => 'ASC',
                    'RbacAcciones.controller' => 'ASC',
                    'RbacAcciones.action' => 'ASC'
                ]
            ]])
            ->first();

        if ($this->getRequest()->is(['patch', 'post', 'put'])) {

            $rbacPerfilNew = $this->RbacPerfiles->patchEntity($rbacPerfil, $this->getRequest()->getData(), ['associated' => ['RbacAcciones']]);
            //debug('Session Save Path: ' . ini_get('session.save_path'));
            //die;

            if ($this->RbacPerfiles->save($rbacPerfilNew)) {

                // Construir el nuevo arreglo de acciones
                $rbacAcciones = [];
                foreach ($rbacPerfilNew->rbac_acciones as $accion) {
                    $controller = Inflector::camelize($accion->controller);
                    $rbacAcciones[$controller][$accion->action] = 1;
                }

                // Actualizar la sesión del usuario logueado (si corresponde)
                $usuarioLogueado = $this->getRequest()->getSession()->read('RbacUsuario.perfil_id');
                if ($id == $usuarioLogueado) {
                    $this->getRequest()->getSession()->write('RbacAcciones', $rbacAcciones);
                }

                // Buscar y actualizar todas las sesiones activas de los usuarios con este perfil
                //$this->actualizarSesionesPerfil($rbacPerfil->id, $rbacAcciones);


                $this->Flash->success(__('El perfil se actualizo correctamente.'));

                return $this->redirect(['plugin' => 'Rbac', 'controller' => 'RbacPerfiles', 'action' => 'index']);
            }
            $this->Flash->error('No se puede actualizar el perfil');
        }
        //debug($_SESSION);
        foreach ($rbacPerfil->rbac_acciones as $k => $accion) {
            $accionesIds[] = $accion->id;
        }

        $rbacPerfilAccionesNoPublicas = $this->RbacPerfiles->RbacAcciones
            ->find()
            ->where(['RbacAcciones.publico '  => 0, 'RbacAcciones.id NOT IN' => $accionesIds])
            ->order(['RbacAcciones.controller', 'RbacAcciones.action'])
            ->all();


        $this->set('rbacPerfilAccionesNoPublicas', $rbacPerfilAccionesNoPublicas);
        $this->set('rbacPerfil', $rbacPerfil);
    }

    private function actualizarSesionesPerfil($perfilId, $rbacAcciones)
    {
        // Ruta donde se almacenan los archivos de sesión
        $sessionSavePath = '../tmp/cache';

        // Verificar que el directorio de sesiones existe
        if (is_dir($sessionSavePath)) {

            // Abrir el directorio y obtener todos los archivos de sesión
            $sessionFiles = scandir($sessionSavePath);

            // Recorrer los archivos de sesión
            foreach ($sessionFiles as $sessionFile) {
                // Ignorar los directorios '.' y '..'
                if ($sessionFile == '.' || $sessionFile == '..' || strpos($sessionFile, 'cake_') !== 0) {
                    continue;
                }
                // Ruta completa del archivo de sesión
                $sessionFilePath = $sessionSavePath . DIRECTORY_SEPARATOR . $sessionFile;

                // Leer el contenido del archivo de sesión
                $sessionData = file_get_contents($sessionFilePath);

                if ($sessionData) {
                    // Deserializar los datos de sesión usando unserialize (para sesiones serializadas por PHP)
                    $sessionData = $this->phpSessionDecode($sessionData);


                    // Verificar si el perfil del usuario en esta sesión es el mismo que el que estamos actualizando
                    if (isset($sessionData['RbacUsuario']['perfil_id']) && $sessionData['RbacUsuario']['perfil_id'] == $perfilId) {

                        // Actualizar las acciones del perfil en la sesión
                        $sessionData['RbacAcciones'] = $rbacAcciones;

                        // Volver a serializar los datos y guardarlos en el archivo de sesión
                        $newSessionData = $this->phpSessionEncode($sessionData);

                        // Guardar los datos actualizados en el archivo de sesión con bloqueo

                        file_put_contents($sessionFilePath, $newSessionData);
                    }
                }
            }
        }
    }

    // Función para decodificar el formato de sesión de PHP
    private function phpSessionDecode($sessionData)
    {
        $returnData = [];
        $offset = 0;

        // Procesar cada variable almacenada en la sesión
        while ($offset < strlen($sessionData)) {
            // Buscar el separador '|'
            $pos = strpos($sessionData, "|", $offset);
            if ($pos === false) {
                break; // No más datos que procesar
            }

            // Extraer el nombre de la variable de sesión
            $varname = substr($sessionData, $offset, $pos - $offset);
            $offset = $pos + 1; // Avanzar después del '|'

            // Extraer el valor serializado y verificar si es un valor serializado válido
            $data = @unserialize(substr($sessionData, $offset));
            if ($data === false) {
                // Si la deserialización falla, es probable que el formato sea diferente
                // y podemos manejar el error, o intentar con otros formatos
                break;
            }

            // Agregar la variable de sesión decodificada al array
            $returnData[$varname] = $data;

            // Avanzar el offset en función de la longitud de la representación serializada
            $offset += strlen(serialize($data));
        }

        return $returnData;
    }


    // Función para serializar el formato de sesión de PHP
    private function phpSessionEncode($sessionData)
    {
        $newSessionData = '';
        foreach ($sessionData as $key => $value) {
            $newSessionData .= $key . "|" . serialize($value);
        }

        return $newSessionData;
    }




    public function delete($id)
    {
        if ($this->getRequest()->is('post')) {
            throw new MethodNotAllowedException();
        }
        try {
            $rbacPerfil = $this->RbacPerfiles->findById($id)->contain(['RbacUsuarios'])->first();

            if (isset($rbacPerfil['rbac_usuarios']) && count($rbacPerfil['rbac_usuarios']) > 0) {
                $this->Flash->error('No se puede eliminar el perfil porque tiene usuarios asociados.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->RbacPerfiles->delete($rbacPerfil);
                $this->Flash->success('El perfil ha sido eliminado correctamente.');
                $this->redirect(array('action' => 'index'));
            }
        } catch (InternalErrorException $e) {
            $this->Flash->error('No se puede eliminar el perfil porque tiene usuarios asociados.');
            return $this->redirect(['plugin' => 'Rbac', 'controller' => 'RbacPerfiles', 'action' => 'index']);
        }
    }

    private function generarListadoAccionesPorPerfiles($perfilesAcciones)
    {
        $rbacAcciones = array();
        foreach ($perfilesAcciones as $key => $perfil) {
            //solo cargo perfiles que tienen acceso a login, los otros no tienen sentido
            if (($perfil['permiso_virtual_host_id'] != 1) && ($perfil['permiso_virtual_host_id'] != 2)) {
                $p['id'] = $perfil['id'];
                $p['descripcion'] = $perfil['descripcion'];
                $perfilesPorUsuario[] = $p;
            }
            foreach ($perfil->rbac_acciones as $accion) {
                $controller = Inflector::camelize($accion['controller']);
                $rbacAcciones[$perfil['id']][$controller][$accion['action']] = array(
                    'value' => 1,
                    'solo_lectura' => $accion['solo_lectura'],
                    'carga_publica' => $accion['carga_publica'],
                    'carga_login_publica' => $accion['carga_login_publica'],
                    'carga_login_interna' => $accion['carga_login_interna'],
                    'carga_administracion' => $accion['carga_administracion']
                );
            }
        }
        $this->getRequest()->getSession()->write('PerfilesPorUsuario', $perfilesPorUsuario);
        $this->getRequest()->getSession()->write('RbacAcciones', $rbacAcciones);
        return $rbacAcciones;
    }

    private function getConditions()
    {
        $data = $this->getRequest()->getQuery();
        $filterErrors = array();
        $conditions['where'] = [];
        $conditions['contain'] = ['RbacUsuarios'];

        if (isset($data['descripcion']) and !empty($data['descripcion'])) {
            $conditions['where'][] = ['RbacPerfiles.descripcion LIKE' => '%' . $data['descripcion'] . '%'];
        }

        $this->set('filterErrors', $filterErrors);
        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());

        return $conditions;
    }
}
