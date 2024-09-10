<?php

namespace Rbac\Controller;

use Cake\Core\Configure;

class RbacAccionesController extends RbacController
{
    public function index()
    {
        $conditions = $this->getConditions();
        $rbacAcciones = $this->RbacAcciones->find()
            ->where($conditions['where'])
            ->group(['controller', 'action'])
            ->order(['controller' => 'ASC', 'action' => 'DESC']);

        $this->set('rbacAcciones', $rbacAcciones->all());
        $this->loadComponent('Rbac.ControllerList');
        $rbacNewControllersActions = $this->ControllerList->get($rbacAcciones);
        // Lista antes de sincronizar...
        $this->set('rbacNuevos', $rbacNewControllersActions);
        $this->set('filters', $this->getRequest()->getQuery());
    }

    public function delete($id)
    {

        $this->request->allowMethod(['post', 'delete']);
        $rbacAccion = $this->RbacAcciones->get($id,contain: ['RbacPerfiles']);
        if (isset($rbacAccion) && $rbacAccion['rbac_perfiles'][0]['accion_default_id'] != $id) {
            if ($this->RbacAcciones->delete($rbacAccion)) {
                $this->Flash->success(__('La acción ha sido eliminada.'));
            } else {
                $this->Flash->error(__('No se pudo eliminar la acción. Por favor, inténtalo de nuevo.'));
            }
        } else {
            $this->Flash->error('La acción ' . $id . ' no puede ser eliminada debido que esta asociada a un perfil');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function requireLogin()
    {
        $this->viewBuilder()->setLayout(false);

        // Obtener los valores del request
        $accion_id = $this->getRequest()->getData('accion_id');
        $atributo_id = $this->getRequest()->getData('atributo_id');
        $valor = $this->getRequest()->getData('valor');

        // Verificar si se recibieron los datos necesarios
        if (empty($accion_id) || empty($atributo_id)) {
            $this->set('data', ['result' => false, 'message' => 'Datos incompletos']);
            return $this->render('/element/ajaxreturn');
        }

        try {
            $rbacAccion = $this->RbacAcciones->get($accion_id);

            $data['id'] = $accion_id;
            $data[$atributo_id] = $valor;

            // Aplicar los cambios a la entidad
            $rbacAccion = $this->RbacAcciones->patchEntity($rbacAccion, $data);

            // Guardar la entidad y verificar si se guardó correctamente
            if ($this->RbacAcciones->save($rbacAccion)) {
                // Éxito
                $result = true;
                $message = 'Acción actualizada correctamente.';
            } else {
                // Error al guardar
                $result = false;
                $message = 'Error al actualizar la acción.';
            }
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            // Si la acción no existe, devolver error
            $result = false;
            $message = 'Acción no encontrada.';
        }

        // Devolver el resultado como JSON
        $this->set('data', [
            'result' => $result,
            'message' => $message
        ]);
        return $this->render('/element/ajaxreturn');
    }

    private function getConditions()
    {
        $data = $this->getRequest()->getQuery();
        $filterErrors = array();
        $conditions['where'] = [];
        $conditions['contain'] = [];

        if (isset($data['controller']) and !empty($data['controller'])) {
            $conditions['where'][] = ['RbacAcciones.controller LIKE' => '%' . $data['controller'] . '%'];
        }

        if (isset($data['action']) and !empty($data['action'])) {
            $conditions['where'][] = ['RbacAcciones.action LIKE ' => '%' . $data['action'] . '%'];
        }

        if (isset($data['public'])) {
            $conditions['where'][] = ['RbacAcciones.publico' => $data['publico']];
        }

        $this->set('filterErrors', $filterErrors);
        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());

        return $conditions;
    }

    public function sincronizar()
    {
        $this->viewBuilder()->setLayout(null);
        $result = FALSE;

        $miArray = $this->getRequest()->getData('miArray');
        $i = 0;

        $perfilDefault = $this->getRequest()->getSession()->read('PerfilDefault');

        if ($perfilDefault == 1) {
            foreach ($miArray as $item) {
                $datos = explode(';', $item);

                $data['plugin'] = $datos[0];
                $data['controller'] = $datos[1];
                $data['action'] = $datos[2];
                $data['carga_administracion'] = 1;

                $rbacAccion = $this->RbacAcciones->newEntity($data);
                if ($this->RbacAcciones->save($rbacAccion)) {
                    $accion_id = $rbacAccion->id;
                    $this->RbacAcciones->getConnection()->execute("INSERT INTO rbac_acciones_rbac_perfiles
		        				(rbac_accion_id,rbac_perfil_id) VALUES (" . $accion_id . ",1)");
                    $result = TRUE;
                } else {
                    $result = FALSE;
                    $this->Flash->error('Error, no pudo grabar correctamente.');
                    break;
                }
            }
        } else {
            foreach ($miArray as $item) {
                $datos = explode(';', $item);

                $data['plugin'] = $datos[0];
                $data[$i]['controller'] = $datos[1];
                $data[$i]['action'] = $datos[2];
                $data[$i]['carga_administracion'] = 1;

                $i++;
            }
            if ($data) {
                $rbacAccion = $this->RbacAcciones->newEntity($data);
                if (!$this->RbacAcciones->saveAll($rbacAccion)) {
                    $result = FALSE;
                    $this->Flash->error('Error, no pudo grabar correctamente.');
                } else {
                    $result = TRUE;
                    $this->Flash->success('Ha sido grabado correctamente', 'flash_custom');
                }
            }
        }
        $this->set('data', $result);
        $this->render('/element/ajaxreturn');
    }
}
