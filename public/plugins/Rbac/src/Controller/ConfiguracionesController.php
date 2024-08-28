<?php

namespace Rbac\Controller;

use Cake\Http\Exception\MethodNotAllowedException;

class ConfiguracionesController extends RbacController
{
    public function _null()
    {
    }

    protected array $paginate = [
        'limit' => 10,
        'order' => [
            'Configuraciones.clave' => 'asc',
        ],
    ];


    public function index($downloadLog = NULL)
    {
        if ($downloadLog != NULL) {

            if ($downloadLog == 1) {
                $this->viewBuilder()->setLayout(null);
                $file_path = ROOT . DS . "logs" . DS . "error.log"; // error_log
                $archivo = 'errorLog' . date('YmdHis');
            }

            if ($downloadLog == 2) { // debug log
                $this->viewBuilder()->setLayout(null);
                $file_path = ROOT . DS . "logs" . DS . "debug.log";
                $archivo = 'debugLog' . date('YmdHis');
            }

            if ($downloadLog == 1 || $downloadLog == 2) {
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header('Content-Type: application/vnd.ms-excel; charset=utf-8');
                header("Content-Disposition: attachment; filename=$archivo.log");
                header("Content-Description: Reporte");
                if (file_exists($file_path)) {
                    print file_get_contents($file_path);
                }
            }

            if ($downloadLog == 3) { // eliminacion de cache
                $files = array();
                $files = array_merge($files, glob(CACHE . '*')); // remove cached css
                // $files = array_merge($files, glob(CACHE . 'css' . DS . '*')); // remove cached css
                // $files = array_merge($files, glob(CACHE . 'js' . DS . '*'));  // remove cached js
                $files = array_merge($files, glob(CACHE . 'models' . DS . '*'));  // remove cached models
                $files = array_merge($files, glob(CACHE . 'persistent' . DS . '*'));  // remove cached persistent
                $mensaje = "Sin archivos de cache encontrados";
                gc_collect_cycles();
                foreach ($files as $f) {
                    if (is_file($f) and  @unlink($f)) {
                        //sunlink($f);
                        $mensaje = "Archivos de cache eliminados";
                    }
                }

                $this->set(compact('files'));
                $this->Flash->success($mensaje, 'flash_custom');
                return $this->redirect('/rbac/configuraciones/index');
            }
            if ($downloadLog == 4) { // limpiar logs
                $file_path = ROOT . DS . "logs" . DS . "error.log"; // error_log
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                $file_path = ROOT . DS . "logs" . DS . "debug.log";
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                $this->Flash->success('Archivos de logs eliminados', 'flash_custom');
                return $this->redirect('/rbac/configuraciones/index');
            }
            exit();
        }


        $this->set('configuraciones', $this->paginate());
    }



    public function agregar()
    {

        if ($this->getRequest()->is('post')) {
            $configuracion = $this->Configuraciones->newEntity($this->getRequest()->getData());
            if (substr($configuracion->clave, -4) == '_enc') {
                $configuracion->valor = $this->secured_encrypt($configuracion->valor);
            }
            if ($this->Configuraciones->save($configuracion)) {
                $this->Flash->success('Se ha creado exitosamente', 'flash_custom');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error('Error, no se pudo agregar');
            }
        }
    }



    public function editar($id = null)
    {

        if (!$id) {
            $this->Flash->error('Accion inválida');
            $this->redirect(array('action' => 'index'));
        }

        $configuracion = $this->Configuraciones->findById($id)->firstOrFail();

        if (!$configuracion) {
            $this->Flash->error('Accion inválida');
            $this->redirect(array('action' => 'index'));
        }

        if ($this->getRequest()->is('post', 'put')) {

            $configuracion = $this->Configuraciones->patchEntity($configuracion, $this->getRequest()->getData());

            if (substr($configuracion->clave, -4) == '_enc') {
                $configuracion->valor = $this->secured_encrypt($configuracion->valor);
            }
            if ($this->Configuraciones->save($configuracion)) {
                $this->Flash->success('Se ha actualizado exitosamente.');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error('No se puede actualizar');
            }
        }
        if (!$this->getRequest()->getData()) {

            if (substr($configuracion->clave, -4) == '_enc') {
                $configuracion->valor = '';
            }
            $this->set('configuracion', $configuracion);
        }
    }

    public function eliminar($id)
    {

        $configuracion = $this->Configuraciones->get($id);
        if ($this->Configuraciones->delete($configuracion)) {
            $this->Flash->success('La configuración ha sido eliminado correctamente.', 'flash_custom');
            $this->redirect(array('action' => 'index'));
        }
    }
}
