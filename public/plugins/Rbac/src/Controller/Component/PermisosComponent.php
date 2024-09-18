<?php
namespace Rbac\Controller\Component;

use Cake\Controller\Component;
use Cake\Http\Exception\InternalErrorException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

class PermisosComponent extends Component
{
	/**
	 * Acceso local al controlador que invoco a la componente.
	 */
	private $RbacAccion = NULL;

	private $Controller = NULL;
	private array $accionesNoPublicasPermitidasSinLogin = ['login', 'recuperar', 'recuperarPass'];

	public function initialize(array $config): void
	{
		$this->RbacAccion  = TableRegistry::getTableLocator()->get('Rbac.RbacAcciones');
		$this->Controller = $this->_registry->getController();
		$this->Verificar();
	}

	public function Verificar()
	{
		$session = $this->Controller->getRequest()->getSession();
		$controlador = Inflector::camelize($this->Controller->getName());
		$accion = $this->Controller->getRequest()->getParam('action');
		$isPublicAction = $this->RbacAccion->isPublicAction($controlador, $accion);


		if (!$isPublicAction) {

			if (is_null($session->read('RbacUsuario'))) {
				//Si no esta logueado solo puede accedeer a las acciones definidas en el array $this->accionesNoPublicasPermitidasSinLogin
				//if (!in_array($accion, $this->accionesNoPublicasPermitidasSinLogin)) {
					return $this->Controller->redirect(array('plugin' => 'rbac', 'controller' => 'rbacUsuarios', 'action' => 'login'));
				//}
			} else {
				$accionesPermitidasPorPerfiles = $session->read('RbacAcciones');
                //debug($accionesPermitidasPorPerfiles);die;
				$tienePermiso = (bool) FALSE;

				if (isset($accionesPermitidasPorPerfiles[$controlador][$accion])) {
					$tienePermiso = (bool) ($accionesPermitidasPorPerfiles[$controlador][$accion] == 1);
				}

				if (!$tienePermiso) {
					throw new InternalErrorException('El usuario no tiene permiso para acceder a la funcionalidad requerida.');
					//return $this->Controller->redirect(array('plugin' => 'rbac', 'controller' => 'rbacUsuarios', 'action' => 'login'));
				}
			}
		}
	}


}
