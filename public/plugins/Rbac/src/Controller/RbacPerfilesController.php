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

            if ($this->RbacPerfiles->save($rbacPerfilNew)) {

                $rbacAcciones = [];
                foreach ($rbacPerfilNew->rbac_acciones as $accion) {

                    $controller = Inflector::camelize($accion->controller);
                    $rbacAcciones[$controller][$accion->action] = 1;
                }
                $usuarioLogueado = $this->getRequest()->getSession()->read('RbacUsuario.perfil_id');

                if ($id == $usuarioLogueado) {
                    $this->getRequest()->getSession()->write('RbacAcciones', $rbacAcciones);
                }

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
