<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Datasource\Exception\MissingDatasourceException;
use Cake\Routing\Router;

class UsuariosController extends AppController
{
    public function _null()
    {
    }

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Rbac.LoginManager');
        $this->loadComponent('Rbac.LdapHandler');
    }

    protected array $paginate = [
        'limit' => 10,
        'order' => [
            'RbacUsuarios.apellido' => 'asc',
        ],
    ];

    public function index()
    {
        $conditions = $this->getConditions();
        $rbacUsuario = $this->fetchTable('Rbac.RbacUsuarios');
        $rbacUsuarios = $rbacUsuario->find()
            ->where($conditions['where'])
            ->contain($conditions['contain']);
        $this->set('rbacUsuarios', $this->paginate($rbacUsuarios));
        $this->set('filters', $this->getRequest()->getQuery());
    }

    /**
     * Agrega un usuario nuevo
     */
    public function agregar()
    {
        $configuraciones = $this->fetchTable('Rbac.Configuraciones');
        $configuracionLDAP       = $configuraciones->findByClave('Mostrar LDAP')->first();

        $this->set('LDAP', $configuracionLDAP);
        $this->RbacUsuarios =  $this->fetchTable('Rbac.RbacUsuarios');
        $rbacUsuario = $this->RbacUsuarios->newEmptyEntity();

        if ($this->getRequest()->is('post')) {
            //$conn = ConnectionManager::get('default');
            try {

                $rbacUsuario = $this->RbacUsuarios->newEntity($this->getRequest()->getData(), ['associated' => ['RbacPerfiles', 'PerfilDefault']]);

                $seed = md5(rand(0, 9999));
                $rbacUsuario['seed'] = $seed;
                $rbacUsuario['activo'] = 1;
                $rbacUsuario['valida_ldap'] = 1;
                $rbacUsuario['perfil_default_id'] = $rbacUsuario['rbac_perfiles'][0]['id'];
                $rbacUsuario['correo'] =  $rbacUsuario['usuario'] . '@mrecic.gob.ar';

                if (!empty($rbacUsuario['password'])) {
                    $rbacUsuario['password'] = hash('sha256', $seed . $rbacUsuario['password']);
                }

                if ($this->RbacUsuarios->save($rbacUsuario)) {

                    if (!$rbacUsuario['valida_ldap']) {
                        $params = Configure::read('params');
                        $id                              = $rbacUsuario->id;
                        $token                           = $this->generateToken();
                        //$this->loadModel('Rbac.RbacToken');
                        $RbacToken = $this->fetchTable('Rbac.RbacToken');
                        $data['token']      = $token;
                        $data['usuario_id'] = $id;
                        $data['validez']    = 1440;
                        $rbacToken = $RbacToken->newEntity($data);
                        $configuracionLDAP       = $configuraciones->findByClave('Mostrar LDAP')->first();

                        $datos               = array();
                        $datos['subject']    = 'Confirmación de nuevo usuario';
                        $datos['url']        = Router::url('/', true) . "rbac/rbac_usuarios/recuperarPass/" . $token;
                        $datos['aplicacion'] = $params['aplicacion'];
                        $datos['template']   = 'nuevo_usuario_noldap';
                        $datos['email']      = $this->getRequest()->getData('correo');

                        $error = 0;
                        if ($RbacToken->save($rbacToken)) {
                            if ($this->_sendEmail($datos)) {
                                $this->RbacUsuarios->getConnection()->commit();
                                $this->Flash->success('Se ha enviado la información para crear la clave de su usuario ingresando a la dirección ' . $this->getRequest()->getData('correo'));
                            } else {
                                $this->RbacUsuarios->getConnection()->rollback();
                                $this->Flash->error('No pudo enviar confirmación de nuevo usuario');
                                $error = 1;
                            }
                        } else {
                            $this->RbacUsuarios->getConnection()->rollback();
                            $this->Flash->error('No pudo generar token antes de enviar confirmacion del nuevo usuario');
                            $error = 1;
                        }
                        if (!$error) {
                            return $this->redirect(array('action' => 'index'));
                        }
                    } else {
                        $this->Flash->success('Se ha creado el usuario ' . $this->getRequest()->getData('usuario'));
                        if ($this->request->getSession()->check('previousUrl')) {
                            $previousUrl = $this->request->getSession()->read('previousUrl');
                        } else {
                            $previousUrl = array('action' => 'index');
                        }
                        return $this->redirect($previousUrl);
                    }
                } else {
                    $this->Flash->error(__('El usuario no pudo ser guardado. Por favor, resuelva los errores e intente nuevamente.'));
                }
            } catch (MissingDatasourceException $e) {
                $this->Flash->error(__('El usuario no pudo ser guardado. Por favor, resuelva los errores e intente nuevamente.'));
            }
        }
        $rbacPerfiles = $this->RbacUsuarios->RbacPerfiles->find('list', keyField: 'id', valueField: 'descripcion')->all();
        $this->set('rbacPerfiles', $rbacPerfiles);
        $this->set(compact('rbacUsuario'));
    }

    public function editar($id = null)
    {
        $this->RbacUsuarios =  $this->fetchTable('Rbac.RbacUsuarios');
        $rbacUsuario = $this->RbacUsuarios->findById($id)->contain(['RbacPerfiles'])->first();

        if ($this->getRequest()->is(['patch', 'post', 'put'])) {

            $rbacUsuario = $this->RbacUsuarios->patchEntity($rbacUsuario, $this->getRequest()->getData(), ['associated' => ['RbacPerfiles'],]);

            if ($this->RbacUsuarios->save($rbacUsuario)) {
                $this->Flash->success('Se ha actualizado exitosamente.');
                if ($this->request->getSession()->check('previousUrl')) {
                    $previousUrl = $this->request->getSession()->read('previousUrl');
                } else {
                    $previousUrl = array('action' => 'index');
                }
                return $this->redirect($previousUrl);
            } else {               
                $this->Flash->error(__('El usuario no pudo ser guardado. Por favor, resuelva los errores e intente nuevamente.'));
            }
        } else {
            $rbacPerfiles = $this->RbacUsuarios->RbacPerfiles->find('list', keyField: 'id', valueField: 'descripcion')->all();

            foreach ($rbacUsuario['rbac_perfiles'] as $perfil) {
                $rbacPerfilesIds[] = $perfil['id'];
            }

            $this->set(compact('rbacUsuario', 'rbacPerfiles', 'rbacPerfilesIds'));
        }
    }

    /**
     * Elimina un usuario
     * @param int $id identificador del usuario a eliminar
     * @param int $ususario_activo  indica si el usuario eliminado es el usuario activo elimina los datos
     * de la sesión y redirije al login
     */
    public function delete($id, $usuario_activo = 0)
    {
        $this->RbacUsuarios =  $this->fetchTable('Rbac.RbacUsuarios');
        $rbacUsuario = $this->RbacUsuarios->get($id, [
            'contain' => ['RbacPerfiles'],
        ]);

        if ($usuario_activo == 1) {
            if ($this->RbacUsuarios->delete($rbacUsuario)) {
                $this->getRequest()->getSession()->destroy();
                $this->redirect(array('action' => 'login'));
            }
        } else {
            if ($this->RbacUsuarios->delete($rbacUsuario)) {
                $this->Flash->success('El Usuario ha sido eliminado correctamente.', 'flash_custom');
                $this->redirect(array('action' => 'index'));
                //return $this->redirect($this->referer());
            }
        }
    }

    public function getConditions()
    {
        $data = $this->getRequest()->getQuery();
        $filterErrors = array();
        $conditions['where'] = [];
        $conditions['contain'] = ['RbacPerfiles', 'PerfilDefault'];

        if (isset($data['nombre']) and !empty($data['nombre'])) {
            $conditions['where'][] = ['RbacUsuarios.nombre LIKE' => '%' . $data['nombre'] . '%'];
        }

        if (isset($data['apellido']) and !empty($data['apellido'])) {
            $conditions['where'][] = ['RbacUsuarios.apellido LIKE ' => '%' . $data['apellido'] . '%'];
        }

        if (isset($data['usuario']) and !empty($data['usuario'])) {
            $conditions['where'][] = ['RbacUsuarios.usuario  ' =>  $data['usuario']];
        }

        if (isset($data['activo'])) {
            $conditions['where'][] = ['RbacUsuarios.activo' => $data['activo']];
        } else {
            $conditions['where'][] = ['RbacUsuarios.activo' => 1];
        }

        $this->set('filterErrors', $filterErrors);
        $this->request->getSession()->write('previousUrl', $this->request->getRequestTarget());
        return $conditions;
    }

    /**
     * Verifica si un usuario existe en LDAP.
     * @return boolean true si el usuario existe en LDAP
     */
    public function validarLoginLdap()
    {

        $this->layout = null;
        $result       = FALSE;
        $usuario      = $this->RbacUsuarios->validar_trigrama_ldap($this->getRequest()->getData('usuario'));
        if ($usuario['result']) {

            $result = TRUE;
        }
        $data = array('result' => $result);
        $this->set('data', $data);
        $this->render('/element/ajaxreturn');
    }

    /**
     * Verifica si un usuario existe en la tabla rbac_usuarios de la DB.
     * @return boolean true si el usuario existe en la DB
     */
    public function validarLoginDB()
    {
        //$this->layout = null;
        $result      = FALSE;
        $rbacUsuario = $this->RbacUsuarios->findByUsuario($this->getRequest()->getData('usuario'))->toArray();

        if (count($rbacUsuario) > 0) {
            $result = TRUE;
        }
        $data = array('result' => $result);
        $this->set('data', $data);

        $this->render('/element/ajaxreturn');
    }
}
