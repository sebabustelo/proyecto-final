<?php

namespace Rbac\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;
use Cake\Datasource\Exception\MissingDatasourceException;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\Mailer\Mailer;
use Cake\Mailer\Exception\MissingActionException;
use Cake\Http\Client;
use Cake\Log\Log;

class RbacUsuariosController extends RbacController
{
    public function _null() {}

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Rbac.LoginManager');
        $this->loadComponent('Rbac.DbHandler');
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
        $rbacUsuarios = $this->RbacUsuarios->find()
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

        $rbacUsuario = $this->RbacUsuarios->newEmptyEntity();
        $this->set(compact('rbacUsuario'));
        if ($this->getRequest()->is('post')) {
            //$conn = ConnectionManager::get('default');
            try {
                $rbacUsuario = $this->RbacUsuarios->newEntity($this->getRequest()->getData(), ['associated' => ['RbacPerfiles']]);

                //$rbacUsuario = $this->RbacUsuarios->patchEntity($rbacUsuario, $this->getRequest()->getData(),['associated'=>['RbacPerfiles','PerfilDefault']]);
                $params = Configure::read('params');
                $seed = md5(rand(0, 9999));
                $rbacUsuario['seed'] = $seed;
                // debug($rbacUsuario);
                if (!empty($rbacUsuario['password'])) {
                    $rbacUsuario['password'] = hash('sha256', $seed . $rbacUsuario['password']);
                }
                // debug($rbacUsuario);die;
                $this->RbacUsuarios->getConnection()->begin();

                if ($this->RbacUsuarios->save($rbacUsuario)) {

                    $id                              = $rbacUsuario->id;
                    $token                           = $this->generateToken();

                    $RbacToken = $this->fetchTable('Rbac.RbacToken');
                    $data['token']      = $token;
                    $data['usuario_id'] = $id;
                    $data['validez']    = 1440;
                    $rbacToken = $RbacToken->newEntity($data);
                    //debug( $rbacToken);die;

                    $datos               = array();
                    $datos['subject']    = 'Confirmación de nuevo usuario';
                    $datos['url']        = Router::url('/', true) . "rbac/rbac_usuarios/recuperarPass/" . $token;
                    $datos['aplicacion'] = "IPMAGNA";
                    $datos['template']   = 'registrarse';
                    $datos['email']      = $this->getRequest()->getData('usuario');
                    //$this->RbacUsuarios->getConnection()->commit();
                    $error = 0;
                    if ($RbacToken->save($rbacToken)) {
                        if ($this->_sendEmail($datos)) {
                            $this->RbacUsuarios->getConnection()->commit();
                            $this->Flash->success('Se ha enviado la información para crear la clave de su usuario ingresando a la dirección ' . $this->getRequest()->getData('usuario'));
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
                    $this->Flash->error(__('El usuario no pudo ser guardado. Por favor, resuelva los errores e intente nuevamente.'));
                    // debug($rbacUsuario);die;
                    $this->RbacUsuarios->getConnection()->rollback();
                    $error_msg = '';
                    // if (!empty($rbacUsuario->invalid('usuario'))) $error_msg .= 'Ya esta registrado usuario, ';
                    // if (!empty($rbacUsuario->invalid('correo'))) $error_msg .= 'Ya esta registrado correo, ';
                    // $this->Flash->error('Error, ' . $error_msg . ' No se puede actualizar');
                    // return $this->redirect(array('action' => 'index'));
                }
            } catch (MissingDatasourceException $e) {
                $this->RbacUsuarios->getConnection()->rollback();
                //$conn->rollback();
                $this->Flash->success(__($e->getMessage()));
                return $this->redirect(array('action' => 'index'));
                //return $this->redirect($this->referer());
            }
        }
        $rbacPerfiles = $this->RbacUsuarios->RbacPerfiles->find('list', keyField: 'id', valueField: 'descripcion')->all();
        $this->set('rbacPerfiles', $rbacPerfiles);
    }

    public function _sendEmail($datos)
    {
        //s $confVals = Configure::read('configVals');
        // $emailConfig = [
        //     'className' => 'Smtp',
        //     'port' => env('EMAIL_PORT', 465),
        //     'host' => env('EMAIL_HOST', 'ssl://smtp.mrecic.gov.ar'),
        //     'username' => $confVals['app_email'],
        //     'password' => $this->secured_decrypt($confVals['app_email_pass_enc']),
        //     'persistent' => env('EMAIL_SOCKET_PERSISTENT', false),
        //     'transport' => env('EMAIL_TRANSPORT', 'Mail'),
        //     'timeout' => env('EMAIL_TIMEOUT', 30),
        //     'tls' => filter_var(env('EMAIL_TLS', true), FILTER_VALIDATE_BOOLEAN),
        //     'context' => [
        //         'ssl' => [
        //             'verify_peer' => filter_var(env('EMAIL_SSL_VERIFY_PEER', false), FILTER_VALIDATE_BOOLEAN),
        //             'verify_peer_name' => filter_var(env('EMAIL_SSL_PEER_NAME', false), FILTER_VALIDATE_BOOLEAN),
        //             'allow_self_signed' => filter_var(env('EMAIL_SSL_ALLOW_SELF_SIGNED', true), FILTER_VALIDATE_BOOLEAN),
        //             'ciphers' => env('EMAIL_SSL_CIPHERS', 'DEFAULT:!DH')
        //         ]
        //     ],
        //     'client' => env('EMAIL_CLIENT', 'IPMagna'),
        //     'charset' => env('EMAIL_CHARSET', 'utf-8'),
        //     'headerCharset' => env('EMAIL_HEADER_CHARSET', 'utf-8'),
        //     'log' => filter_var(env('EMAIL_LOG', false), FILTER_VALIDATE_BOOLEAN),
        // ];



        $mailer = new Mailer('default');
        try {
            $mailer->setFrom(['ipmagna@gmail.com' => 'IPMAGNA'])
                ->setTo($datos['email'])
                ->setSubject($datos['subject'])
                ->setEmailFormat('html')
                ->setViewVars(['url' => @$datos['url']])
                ->viewBuilder()
                ->setTemplate($datos['template']);
            //->deliver();
            $mailer->deliver();

            $this->Flash->success('Correo enviado con éxito.');
            return true;
        } catch (MissingActionException $e) {
            Log::error('Error al enviar el correo: ' . $e->getMessage());
            // Error al encontrar la acción del correo (plantilla faltante, etc.)
            $this->Flash->error('Error en el envío: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Error al enviar el correo: ' . $e->getMessage());
            // Cualquier otro tipo de error
            $this->Flash->error('Se produjo un error inesperado: ' . $e->getMessage());
        }
    }

    /**
     * Editar method
     *
     * @param string|null $id Usuario id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function editar($id = null)
    {
        $rbacUsuario = $this->RbacUsuarios->findById($id)->contain(['RbacPerfiles'])->first();
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $rbacUsuario = $this->RbacUsuarios->patchEntity($rbacUsuario, $this->getRequest()->getData(), ['associated' => ['RbacPerfiles']]);
            if ($this->RbacUsuarios->save($rbacUsuario)) {
                $this->Flash->success(__('El Usuario se guardo exitosamente.'));
                $previousUrl = $this->request->getSession()->read('previousUrl');
                return $this->redirect($previousUrl);
            }
            $this->Flash->error(__('El usuario no pudo ser guardado. Por favor, resuelva los errores e intente nuevamente.'));
        }
        $rbacPerfiles = $this->RbacUsuarios->RbacPerfiles->find('list', keyField: 'id', valueField: 'descripcion')->all();
        $this->set('rbacPerfiles', $rbacPerfiles);
        $this->set(compact('rbacUsuario'));
    }

    /**
     * Elimina un usuario
     * @param int $id identificador del usuario a eliminar
     * @param int $ususario_activo  indica si el usuario eliminado es el usuario activo elimina los datos
     * de la sesión y redirije al login
     */
    public function delete($id, $usuario_activo = 0)
    {
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
        $conditions['contain'] = ['RbacPerfiles'];

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

    public function login()
    {
        $this->viewBuilder()->setLayout('Rbac.login');
        $session = $this->getRequest()->getSession();
        //session_destroy();
        //session_start();

        $configuraciones = $this->fetchTable('Rbac.Configuraciones');
        $configuracionCaptcha        = $configuraciones->findByClave('Mostrar Captcha')->first();

        $this->set('captcha', $configuracionCaptcha->valor);

        $captchaPublic       = $configuraciones->findByClave('reCaptchaPublic')->first();
        $this->set('captchaPublic', $captchaPublic->valor);


        if ($this->getRequest()->is('Post')) {
            $this->data = $this->getRequest()->getData('data');

            //validación de captcha
            if ($configuracionCaptcha->valor == 'Si') {

                $captchaSecret        = $configuraciones->findByClave('reCaptchaSecret')->first();

                $recaptcha = $this->request->getData('g-recaptcha-response');
                $secret = $captchaSecret->valor;

                $http = new Client();
                $response = $http->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $secret,
                    'response' => $recaptcha,
                ]);
                $result = json_decode($response->getBody(), true);

            }else{
                $result['success']=true;
            }

            //validacion de usuario
            if ($result['success']) {
                $usuario  = $this->request->getData('usuario');
                $password = $this->request->getData('password');

                $usr = $this->RbacUsuarios->findByUsuario($usuario)->contain(['RbacPerfiles' => ['RbacAcciones']])->first();
                $this->LoginManager->setUserAndPassword($usuario, hash('sha256', $usr->seed . $password));

                if (isset($usr->id)) {
                    $usuarioValido = $this->LoginManager->autenticacion($this->DbHandler);
                } else {
                    $usuarioValido = false;
                }

                if ($usuarioValido) {

                    $perfilDefault = $usr->perfil_id;
                    $this->generarListadoAccionesPorPerfiles($usr->rbac_perfil);

                    $session->write('RbacUsuario', $usr);
                    $session->write('PerfilDefault', $perfilDefault);
                    $session->write('Auth.User', $usr);

                    if ($session->check('redirect')) {
                        $redirect = $session->read('redirect');
                        $session->delete('redirect');
                        $this->redirect($redirect);
                    } else
                        $this->redirect($this->getUrlRedirect($perfilDefault));
                } else {
                    $session->delete('PerfilDefault');
                    $session->delete('RbacUsuario');
                    $this->Flash->error('Usuario y/o contraseña incorrecta.');
                    //return $this->redirect("/login");die;
                }
             } else {
                $this->Flash->error(__('reCAPTCHA no válido.'));
            }
        }
    }

    public function logout()
    {
        $session = $this->getRequest()->getSession();
        $session->destroy();

        return $this->redirect("/login");
    }

    public function register() {}

    /**
     * @param array $perfilesAcciones
     * @return array $rbacAcciones
     */


    private function generarListadoAccionesPorPerfiles($perfilAcciones)
    {

        $rbacAcciones = array();
        $p['id']              = $perfilAcciones->id;
        $p['descripcion']     = $perfilAcciones->descripcion;
        $perfilesPorUsuario[] = $p;

        // debug($perfilAcciones);die;

        foreach ($perfilAcciones->rbac_acciones as $accion) {
            $controller = Inflector::camelize($accion['controller']);
            $rbacAcciones[$controller][$accion->action] = 1;
        }

        $this->getRequest()->getSession()->write('PerfilesPorUsuario', $perfilesPorUsuario);
        $this->getRequest()->getSession()->write('RbacAcciones', $rbacAcciones);
    }

    /**
     * Permite modificar la contraseña del usuario
     */
    public function changePass()
    {

        $usuario = $this->getRequest()->getSession()->read('RbacUsuario');
        if ($this->getRequest()->is('post')) {
            $this->RbacUsuarios->recursive = -1;
            $user = $this->RbacUsuarios->get($usuario['id']);
            $seed = $user['seed'];
            $contrasenia = $user['password'];
            $contraseniaActual = $this->getRequest()->getData('contraseniaActual');
            $contraseniaActualEncrypt = hash('sha256', $seed . $contraseniaActual);
            if ($contrasenia != $contraseniaActualEncrypt) {
                $this->Flash->error('La contraseña actual no es correcta.');
            }

            $contraseniaNueva = $this->getRequest()->getData('contraseniaNueva');
            $contraseniaNuevaConfirm = $this->getRequest()->getData('contraseniaNuevaConfirm');

            if ($contraseniaNueva != $contraseniaNuevaConfirm) {
                $this->Flash->error('La confirmación de nueva contraseña es incorrecta.');
            }

            $user['RbacUsuario']['password'] = hash('sha256', $seed . $contraseniaNueva);
            //$user['RbacUsuario']['contraseniaOld'] = $contrasenia;

            if ($this->RbacUsuarios->saveAll($user)) {
                $this->Flash->success('La contraseña fue modificada correctamente.');
                //$this->redirect(array('controller' => 'rbac_usuarios', 'action' => 'index'));
                $this->redirect($this->referer());
            }
        } else {
            $this->RbacUsuarios->recursive = -1;
            $user = $this->RbacUsuarios->findById($usuario['id']);
            $this->set('user', $user->toArray());
        }
    }

    /**
     * Permite recuperar la contraseña a un usuario no LDAP
     */
    public function recuperar($cache = null)
    {

        $this->Configuraciones = $this->fetchTable('Rbac.Configuraciones');
        //$this->loadModel('Rbac.Configuraciones');
        $captcha_public        = $this->Configuraciones->findByClave('reCaptchaPublic');
        $this->set('captcha_public', $captcha_public->toArray());

        //$this->ViewBuilder()->setLayout('Rbac.login');
        if ($this->getRequest()->is('post')) {


            $captchaOk = false;

            if (isset($_POST['g-recaptcha-response']) && $this->verifyRecaptcha($_POST['g-recaptcha-response'])) {
                $captchaOk = true;
            }

            if ($captchaOk) {
                if (strtolower($this->getRequest()->getSession()->read('hash')) == strtolower($this->getRequest()->getData('captcha'))) {
                    //$usuario = $this->RbacUsuarios->find('first', array('conditions' => array('correo' => $this->getRequest()->getData('correo'))))->toArray();
                    $usuario = $this->RbacUsuarios->find()->where(['correo' => $this->getRequest()->getData('correo')])->first();
                    //->contain(['RbacPerfiles' => ['RbacAcciones']])
                    if (!empty($usuario)) {
                        $params = Configure::read('params');
                        //$url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
                        $token = $this->generateToken();
                        $data['token'] = $token;
                        $data['usuario_id'] = $usuario->id;
                        $data['validez'] = 1440;

                        $datos = array();
                        $datos['subject'] = 'Recuperar contraseña';
                        $datos['url'] = Router::url('/', true) . "rbac/rbac_usuarios/recuperarPass/" . $token;
                        $datos['aplicacion'] = $params['aplicacion'];
                        $datos['template'] = 'recuperar_contrasenia';
                        $datos['email'] = $this->getRequest()->getData('correo');
                        if ($this->_sendEmail($datos)) {
                            $this->RbacToken = $this->fetchTable('Rbac.RbacToken');
                            $rbacToken = $this->RbacToken->newEntity($data);
                            //$rbacToken = $this->RbacToken->patchEntity($rbacToken, $data);
                            if ($this->RbacToken->save($rbacToken)) {
                                $this->Flash->success(
                                    'Se ha enviado la información para recuperar la clave al usuario ingresado a la dirección ' . $this->getRequest()->getData('correo')
                                );
                            }
                        } else {
                            $this->Flash->error($this->Email->smtpError);
                        }
                    } else {
                        $this->Flash->error('No encuentra correo para enviar la informacón de recuperar contraseña');
                        $this->redirect(array('controller' => 'rbac_usuarios', 'action' => 'login'));
                    }
                }
            }
        }
    }

    /**
     * Permite recuperar el password a partir del token enviado por mail al usuario
     * @param $token
     */
    public function recuperarPass($token)
    {
        $this->RbacToken = $this->fetchTable('Rbac.RbacToken');
        //$this->loadModel('Rbac.RbacToken');
        $result = $this->RbacToken->find()->where(['token' => $token])->first();
        if (!empty($result)) {
            $fecha_actual   = strtotime('now');
            $fecha_creacion = strtotime($result->created);
            $minutos        = ($fecha_actual - $fecha_creacion) / 60;
            //debug($minutos); die;
            if ($minutos < strtotime($result->validez)) {
                $id   = $result->usuario_id;
                $user = $this->RbacUsuarios->get($id);
                if ($this->getRequest()->is('post')) {
                    $this->RbacUsuarios->recursive = -1;
                    $seed = $user->seed;
                    $contraseniaNueva        = $this->getRequest()->getData('contraseniaNueva');
                    $contraseniaNuevaConfirm = $this->getRequest()->getData('contraseniaNuevaConfirm');
                    $usuario['id']       = $id;
                    $usuario['password'] = hash('sha256', $seed . $contraseniaNueva);
                    $usuario['usuario'] = $user->usuario;
                    $usuario['correo'] = $user->correo;
                    $usuario = $this->RbacUsuarios->patchEntity($user, $usuario);
                    if ($this->RbacUsuarios->save($usuario)) {
                        $this->Flash->success('Ha sido restablecido correctamente');
                        $this->redirect(array('controller' => 'rbac_usuarios', 'action' => 'login'));
                    } else {
                        $this->Flash->error('No pudo cambiar contraseña. Por favor contacto con el administrador');
                    }
                }
                $this->set(compact('user', 'token'));
            } else {
                $this->redirect(array('controller' => 'rbac_usuarios', 'action' => 'login', 1));
            }
        } else {
            $this->redirect(array('controller' => 'rbac_usuarios', 'action' => 'login', 1));
        }
    }


    /*
 	* Descripcion: Dado un Perfil, devuelve la url de redireccion segun virtual host y accion de inicio
 	*/

    private function getUrlRedirect($perfilId)
    {

        $baseUri = Configure::read('app.fullBaseUrl');
        //$RbacPerfil = $this->loadModel('Rbac.RbacPerfiles');
        $RbacPerfil = $this->fetchTable('Rbac.RbacPerfiles');
        $perfil     = $RbacPerfil->findById($perfilId)->toArray();
        //$RbacAccion = $this->loadModel('Rbac.RbacAcciones');
        $RbacAccion = $this->fetchTable('Rbac.RbacAcciones');
        $accion     = $RbacAccion->findById($perfil[0]['accion_default_id'])->toArray();
        if (!empty($accion[0]['controller'])) {
            $pg = '';
            if (similar_text('Rbac', $accion[0]['controller']) == 4) {
                $pg = 'rbac/';
            }
        } else {
            throw new NotFoundException('Perfil inválido o Sesión expirada, consulte con el administrador');
        }
        return $baseUri . '/' . $pg . $accion[0]['controller'] . '/' . $accion[0]['action'];
    }

    private function verifyReCaptcha($recaptchaCode)
    {
        $this->Configuraciones = $this->fetchTable('Rbac.Configuraciones');
        $captcha_verify_url = $this->Configuraciones->findByClave('reCaptchaURL');
        $captcha_verify_url = $captcha_verify_url->toArray();
        $captcha_verify_url = $captcha_verify_url[0]['valor'];

        $captcha_secret = $this->Configuraciones->findByClave('reCaptchaSecret');
        $captcha_secret = $captcha_secret->toArray();
        $captcha_secret = $captcha_secret[0]['valor'];



        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $captcha_verify_url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "secret=" . $captcha_secret . "&remoteip=" . $_SERVER['REMOTE_ADDR'] . "&response=" . $recaptchaCode);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $captcha_output = curl_exec($curl);
        curl_close($curl);
        $decoded_captcha = json_decode($captcha_output);
        return $decoded_captcha->success; // store validation result to a variable.

    }
}
