<?php
namespace Rbac\Controller\Component;

use Cake\Controller\Component;
//use Cake\Http\Session;

class LoginManagerComponent extends Component {
    
    public array $uses = ['Rbac.RbacUsuario', 'Rbac.Configuracion', 'Rbac.RbacToken' ];
    protected array $components = ['Rbac.LdapHandler', 'Rbac.DbHandler', 'Email'];
    
    protected $user = null;
    protected $password = null;


    public function setUserAndPassword($user,$password){

        $this->setUser($user);
        $this->setPassword($password);
    }
    
    public function setUser($user){
        $this->user = $user;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function autenticacion(LoginInterface $login){

         return $login->autenticacion($this->user,$this->password);
    	
    }
	
	public function getUsuario(LoginInterface $login){

         return $login->getUsuario($this->user);
    	
    }
    
  
}
