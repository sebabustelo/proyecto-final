<?php

namespace Rbac\Controller;

use Cake\Core\Configure;

class RbacAccionesController extends RbacController
{
	public function index()
	{
		if ($this->getRequest()->is('post')) {
			$data = $this->getRequest()->getData();
			// Resultado de busqueda

			$rbacAcciones = $this->RbacAcciones->find()->where(['controller like'=>'%'.trim($data['controller']).'%', 'action like'=>'%'.trim($data['action']).'%'])->group(['controller', 'action'])->order(['controller' => 'ASC', 'action' => 'DESC'])->toArray();
            debug($rbacAcciones);
			$this->set('rbacAcciones', $rbacAcciones);
			$this->set('action', trim($data['action']));
			$this->set('controller', trim($data['controller']));
		} else {
			//Busco todas las acciones que estan cargadas en la base con sus respectivos plugin y controller
			$rbacControllerActions = $this->RbacAcciones->find()->group(['controller', 'action'])->order(['controller' => 'ASC', 'action' => 'DESC'])->toArray();
			//Busco los controladores y acciones que aun no han sido cargadas en la DB y las agrego
			$this->loadComponent('Rbac.ControllerList');
			$rbacNewControllersActions = $this->ControllerList->get($rbacControllerActions);

			// Lista antes de sincronizar...
			$this->set('rbacNuevos', $rbacNewControllersActions);
			// Lista de acciones sincronizados
			$this->set('rbacAcciones', $rbacControllerActions);
			$this->set('action', "");
			$this->set('controller', "");
		}
	}

	public function switchAccion()
	{
		$this->viewBuilder()->setLayout(null);
		$accion_id = $this->getRequest()->getData('accion_id');
		$atributo_id = $this->getRequest()->getData('atributo_id');
		$valor = $this->getRequest()->getData('valor');

		$rbacAccion = $this->RbacAcciones->get($accion_id);

		$result = TRUE;

		if (!$rbacAccion) $result = FALSE;

		$data['id'] = $accion_id;
		$data[$atributo_id] = $valor;

		$rbacAccion = $this->RbacAcciones->patchEntity($rbacAccion, $data);

		if (!$this->RbacAcciones->save($rbacAccion)) {
			$result = FALSE;
		}

		$this->set('data', array('result' => $result));
		$this->render('/element/ajaxreturn');
	}

	public function eliminar($id)
	{
		$this->viewBuilder()->setLayout(null);
		if ($id) {
			$rbacAccion = $this->RbacAcciones->get($id, contain : ['RbacPerfiles']);

			if (isset($rbacAccion) && $rbacAccion['rbac_perfiles'][0]['accion_default_id'] != $id) {
				if ($this->RbacAcciones->delete($rbacAccion)) {
					$this->Flash->success('La Acción con identificador ' . $id . ' ha sido eliminada correctamente.');
				} else {
					$this->Flash->error('No pudo eliminar esta accion con identificador ' . $id . ' correctamente.');
				}
			} else {
				$this->Flash->error('La acción ' . $id . ' no puede ser eliminada debido que esta asociada a un perfil');
			}
		}
		$this->redirect(array('action' => 'index'));
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
