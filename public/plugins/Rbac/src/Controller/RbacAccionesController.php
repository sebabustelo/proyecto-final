<?php

namespace Rbac\Controller;

use Cake\Core\Configure;

class RbacAccionesController extends RbacController
{
    public function index()
    {
        //debug(ini_get('session.save_path'));
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
        $rbacAccion = $this->RbacAcciones->get($id, contain: ['RbacPerfiles']);

        if ($this->RbacAcciones->delete($rbacAccion)) {
            $this->Flash->success(__('La acción ha sido eliminada.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar la acción. Por favor, inténtalo de nuevo.'));
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
        $result = false;

        // Obtener los datos enviados desde el formulario
        $accionesSincronizar = $this->getRequest()->getData('accionesSincronizar');

        // Verificar si hay datos para sincronizar
        if (!empty($accionesSincronizar)) {
            $data = [];
            foreach ($accionesSincronizar as $item) {
                // Dividir los datos por ';'
                $datos = explode(';', $item);

                // Estructurar el array de datos
                $data[] = [
                    'plugin'     => $datos[0] ?? null,
                    'controller' => $datos[1] ?? null,
                    'action'     => $datos[2] ?? null,
                    'publico'    => 0 // Asumimos que siempre es 0
                ];
            }

            // Solo continuar si se han recopilado datos válidos
            if (!empty($data)) {
                // Crear entidades en masa
                $rbacAcciones = $this->RbacAcciones->newEntities($data);

                // Intentar guardar todas las acciones
                if ($this->RbacAcciones->saveMany($rbacAcciones)) {
                    $result = true;
                    $this->Flash->success('Ha sido grabado correctamente', 'flash_custom');
                } else {
                    $this->Flash->error('Error, no se pudo grabar correctamente.');
                }
            }
        } else {
            $this->Flash->error('No se recibieron datos para sincronizar.');
        }

        $this->set('data', $result);
        return $this->render('/element/ajaxreturn');
    }
}
