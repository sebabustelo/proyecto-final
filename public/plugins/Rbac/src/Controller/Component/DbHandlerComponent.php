<?php
namespace Rbac\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Http\Exception\InternalErrorException;

class DbHandlerComponent extends Component implements LoginInterface{

	private $RbacUsuarios;

	public function initialize(array $config):void {
		$this->controller = $this->_registry->getController();
	    $this->RbacUsuarios = TableRegistry::getTableLocator()->get('Rbac.RbacUsuarios');
	}

	/**
	 * El metodo verifica que el nombre de usuario existe y esta activo.
	 * Si el nombre de usuario existe y esta activo, verifica que la correspondencia de la contraseña.
	 * @param string $usuario
	 * @param string $password
	 * @return boolean, TRUE si la autenticacion es correcta, FALSE en caso contrario.
	 */
	public function autenticacion($usuario, $password) {

        if ($this->RbacUsuarios->autenticacion($usuario, $password)) {
        	return true;
        } else {
            return false;
        }
	}

	/**
	 * El metodo devuelve los datos del usuario registrado en el servidor LDAP.
	 * @param string trigrama.
	 * Retorna un arreglo con el siguiente formato:
	 * 			data[usuario],
	 * 			data[nombres],
	 * 			data[apellidos].
	 * Si el trigrama no existe ó no esta activo retorna NULL.
	 *
	 * @return array
	 */
	public function getUsuario($usuario){
        $data = NULL;

        $result = $this->RbacUsuarios->findByUsuario($usuario)->first();


        if (isset($result->id)) {
            throw new InternalErrorException("El usuario ". $usuario ." no fue encontrado .");
        } else {
			return $result;
        }

	}

}
