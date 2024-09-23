<?php

namespace Rbac\Controller;

use Cake\Core\Configure;
use Cake\Datasource\Exception\MissingDatasourceException;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\Mailer\Mailer;
use Cake\Mailer\Exception\MissingActionException;
use Cake\Http\Client;
use Cake\Log\Log;
use Cake\Validation\Validator;

class RbacUsuariosController extends RbacController
{

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
    public function add()
    {
        $configuraciones = $this->fetchTable('Rbac.Configuraciones');

        $rbacUsuario = $this->RbacUsuarios->newEmptyEntity();
        $this->set(compact('rbacUsuario'));
        if ($this->getRequest()->is('post')) {

            try {
                $rbacUsuario = $this->RbacUsuarios->newEntity($this->getRequest()->getData(), ['associated' => ['RbacPerfiles']]);

                $seed = md5(rand(0, 9999));
                $rbacUsuario['seed'] = $seed;

                if (!empty($rbacUsuario['password'])) {
                    $rbacUsuario['password'] = hash('sha256', $seed . $rbacUsuario['password']);
                }

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
                    $datos['url']        = Router::url('/', true) . "rbac/rbac_usuarios/registerPassword/" . $token;
                    $datos['aplicacion'] = "IPMAGNA";
                    $datos['template']   = 'registrarse';
                    $datos['email']      = $this->getRequest()->getData('usuario');

                    if ($RbacToken->save($rbacToken)) {
                        if ($this->sendEmail($datos)) {
                            $this->RbacUsuarios->getConnection()->commit();
                            $this->Flash->success('Se ha enviado la información para crear la clave de su usuario ingresando a la dirección ' . $this->getRequest()->getData('usuario'));
                        } else {
                            $this->RbacUsuarios->getConnection()->rollback();
                            $this->Flash->error('No se pudo enviar el email de confirmación de nuevo usuario');
                        }
                    } else {
                        $RbacToken->getConnection()->rollback();
                        $this->Flash->error('No se pudo generar token antes de enviar confirmación del nuevo usuario');
                    }
                } else {
                    $this->Flash->error(__('El usuario no pudo ser guardado. Por favor, resuelva los errores e intente nuevamente.'));
                    $this->RbacUsuarios->getConnection()->rollback();
                }
            } catch (MissingDatasourceException $e) {
                $this->RbacUsuarios->getConnection()->rollback();
                $this->Flash->success(__($e->getMessage()));
                return $this->redirect(array('action' => 'index'));
            }
        }
        $rbacPerfiles = $this->RbacUsuarios->RbacPerfiles->find('list', keyField: 'id', valueField: 'descripcion')->all();
        $this->set('rbacPerfiles', $rbacPerfiles);
        $this->set('tipoDocumentos', $this->RbacUsuarios->TipoDocumentos->find('list')->order('descripcion')->all());
    }

    /**
     * Editar method
     *
     * @param string|null $id Usuario id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rbacUsuario = $this->RbacUsuarios->findById($id)->contain(['RbacPerfiles', 'TipoDocumentos'])->first();
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $rbacUsuario = $this->RbacUsuarios->patchEntity($rbacUsuario, $this->getRequest()->getData(), ['associated' => ['RbacPerfiles']]);
            if ($this->RbacUsuarios->save($rbacUsuario)) {
                $this->Flash->success(__('El Usuario se guardo correctamente.'));
                $previousUrl = $this->request->getSession()->read('previousUrl');
                return $this->redirect($previousUrl);
            }
            $this->Flash->error(__('El usuario no pudo ser guardado. Por favor, resuelva los errores e intente nuevamente.'));
        }
        $rbacPerfiles = $this->RbacUsuarios->RbacPerfiles->find('list', keyField: 'id', valueField: 'descripcion')->all();
        $this->set('rbacPerfiles', $rbacPerfiles);
        $this->set(compact('rbacUsuario'));
        $this->set('tipoDocumentos', $this->RbacUsuarios->TipoDocumentos->find('list')->order('descripcion')->all());
    }

    public function detail($id = null)
    {
        $rbacUsuario = $this->RbacUsuarios->findById($id)
            ->contain([
                'RbacPerfiles',
                'TipoDocumentos',
                'Direcciones' => [
                    'Localidades' => ['Provincias']
                ]
            ])->first();
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
        $this->set('tipoDocumentos', $this->RbacUsuarios->TipoDocumentos->find('list')->order('descripcion')->all());
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

    private function sendEmail($datos)
    {
        $mailer = new Mailer('default');
        try {
            $mailer->setFrom(['ipmagna-noreply@gmail.com' => 'IPMAGNA'])
                ->setTo($datos['email'])
                ->setSubject($datos['subject'])
                ->setEmailFormat('html')
                ->setViewVars(['url' => @$datos['url']])
                ->viewBuilder()
                ->setTemplate($datos['template'])
                ->setPlugin('Rbac');

            $mailer->deliver();

            return true;
        } catch (MissingActionException $e) {
            Log::error('Error al enviar el correo: ' . $e->getMessage());
            // Error al encontrar la acción del correo (plantilla faltante, etc.)
            $this->Flash->error('Error en el envío: ' . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            Log::error('Error al enviar el correo: ' . $e->getMessage());
            // Cualquier otro tipo de error
            $this->Flash->error('Se produjo un error inesperado: ' . $e->getMessage());
            return false;
        }
    }

    private function getConditions()
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
            $conditions['where'][] = ['RbacUsuarios.usuario  LIKE' =>   '%' . $data['usuario'] . '%'];
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
        $session = $this->getRequest()->getSession();
        //session_destroy();
        //session_start();
        $configuraciones = $this->fetchTable('Rbac.Configuraciones');
        $configuracionCaptcha        = $configuraciones->findByClave('Mostrar Captcha')->first();
        $this->set('captcha', $configuracionCaptcha->valor);

        if ($this->getRequest()->is('Post')) {

            //validación de captcha
            if ($configuracionCaptcha->valor == 'Si') {

                $recaptcha = $this->request->getData('g-recaptcha-response');

                $http = new Client();
                $response = $http->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => env('RECAPTCHA_CLAVE_SECRETA'),
                    'response' => $recaptcha,
                ]);
                $result = json_decode($response->getBody(), true);
            } else {
                $result['success'] = true;
            }
            //validacion de usuario correcta
            if ($result['success']) {
                $usuario  = $this->request->getData('usuario');
                $password = $this->request->getData('password');

                $usr = $this->RbacUsuarios
                    ->findByUsuario($usuario)
                    ->contain(['RbacPerfiles' => ['RbacAcciones', 'RbacAccionDefault']])
                    ->first();

                if (isset($usr->id) and $usr->activo) {
                    $this->LoginManager->setUserAndPassword($usuario, hash('sha256', $usr->seed . $password));
                    $usuarioValido = $this->LoginManager->autenticacion($this->DbHandler);
                    if ($usuarioValido) {

                        $rbac_perfil = $usr->rbac_perfil;

                        $rbacAcciones = array();
                        $p['id']              = $rbac_perfil->id;
                        $p['descripcion']     = $rbac_perfil->descripcion;
                        $perfilesPorUsuario[] = $p;

                        foreach ($rbac_perfil->rbac_acciones as $accion) {
                            $controller = Inflector::camelize($accion['controller']);
                            $rbacAcciones[$controller][$accion->action] = 1;
                        }

                        $session->write('RbacAcciones', $rbacAcciones);
                        $session->write('RbacUsuario', $usr);

                        $pluginRedirect = (!empty($rbac_perfil['accion_default']['plugin'])) ? $rbac_perfil['accion_default']['plugin'] : '';

                        $controllerRedirect = $usr->rbac_perfil['accion_default']['controller'];
                        $actionRedirect = $usr->rbac_perfil['accion_default']['action'];
                        if (!empty($pluginRedirect)) {
                            $redirectParams = ['plugin' => $pluginRedirect, 'controller' => $controllerRedirect, 'action' => $actionRedirect];
                            return $this->redirect($redirectParams);
                        } else {
                            $redirectParams = ['controller' => $controllerRedirect, 'action' => $actionRedirect];
                            return $this->redirect("/" . $controllerRedirect . "/" . $actionRedirect);
                        }
                    } else {
                        $this->Flash->error('Usuario y/o contraseña incorrecta.');
                    }
                } elseif (isset($usr->id) and !$usr->activo) {
                    $usuarioValido = false;
                    $this->Flash->error('El usuario se encuentra en el sistema pero no esta activo .Debe comunicarse con la administracion 454654654 o enviar un mail a ipmagna@gmail.com');
                } else {
                    $this->Flash->error('Usuario y/o contraseña incorrecta.');
                }
            } else {
                $this->Flash->error(__('CAPTCHA no válido.'));
            }
        }
    }

    public function logout()
    {
        $session = $this->getRequest()->getSession();
        $session->destroy();
        return $this->redirect("/login");
    }

    public function register()
    {
        $configuraciones = $this->fetchTable('Rbac.Configuraciones');
        $configuracionCaptcha        = $configuraciones->findByClave('Mostrar Captcha')->first();
        $this->set('captcha', $configuracionCaptcha->valor);

        $rbacUsuario = $this->RbacUsuarios->newEmptyEntity();
        $this->set(compact('rbacUsuario'));
        if ($this->getRequest()->is('post')) {

            //El usuario que se registra tiene el perfil por defecto [Cliente]
            $perfilCliente        = $configuraciones->findByClave('Perfil Cliente')->first();
            $data = $this->getRequest()->getData();
            $data['perfil_id'] = $perfilCliente->valor;
            //Hasta que no valide el mail el usuario esta inactivo
            $data['activo'] = 0;
            $rbacUsuario = $this->RbacUsuarios->newEntity($data, ['associated' => ['RbacPerfiles', 'Direcciones']]);

            if ($rbacUsuario->getErrors()) {
                foreach ($rbacUsuario->getErrors() as $field => $errors) {
                    foreach ($errors as $error) {
                        $this->Flash->error(__($error));
                    }
                }
            } else {

                try {
                    $this->RbacUsuarios->getConnection()->begin();

                    if ($this->RbacUsuarios->save($rbacUsuario)) {


                        $token                           = $this->generateToken();

                        $rbacTokenTable = $this->fetchTable('Rbac.RbacToken');
                        $data['token']      = $token;
                        $data['rbac_usuario_id'] = $rbacUsuario->id;
                        $data['validez']    = 1440;
                        $rbacToken = $rbacTokenTable->newEntity($data);

                        $datos               = array();
                        $datos['subject']    = 'Confirmación de registro nuevo usuario';
                        $datos['url']        = Router::url('/', true) . "rbac/rbac_usuarios/registerPassword/" . $token;
                        $datos['aplicacion'] = "IPMAGNA";
                        $datos['template']   = 'register';
                        $datos['email']      = $this->getRequest()->getData('usuario');

                        if ($rbacTokenTable->save($rbacToken)) {
                            if ($this->sendEmail($datos)) {
                                $this->RbacUsuarios->getConnection()->commit();
                                $this->Flash->success('Se ha enviado la información a ' . $data['usuario'] . ' para crear una nueva contraseña.
                                Por favor, ingrese al enlace que se encuentra en la descripción del email');
                            } else {
                                // $this->RbacUsuarios->getConnection()->rollback();
                                $this->Flash->error('No se pudo enviar el email de confirmación de nuevo usuario');
                            }
                        } else {
                            $this->RbacUsuarios->getConnection()->rollback();
                            $this->Flash->error('No se pudo generar token para enviar la confirmación del nuevo usuario');
                        }
                    } else {
                        $this->Flash->error(__('El usuario no pudo ser guardado. Por favor, resuelva los errores e intente nuevamente.'));
                        $this->RbacUsuarios->getConnection()->rollback();
                    }
                } catch (MissingDatasourceException $e) {
                    $this->RbacUsuarios->getConnection()->rollback();
                    $this->Flash->success(__($e->getMessage()));
                }
            }
        }
        $this->set('tipoDocumentos', $this->RbacUsuarios->TipoDocumentos->find('list')->order('descripcion')->all());
        $this->set('provincias', $this->RbacUsuarios->Direcciones->Localidades->Provincias->find('list')->order('nombre')->all());
    }

    /**
     * Permite registrar el password a partir del token enviado por mail al usuario
     *
     * @param string $token Token único enviado al correo del usuario
     * @return \Cake\Http\Response|null Redirecciona al login o muestra el formulario
     */
    public function registerPassword($token)
    {
        $this->RbacToken = $this->fetchTable('Rbac.RbacToken');

        $result = $this->RbacToken->find()->where(['token' => $token])->first();

        if (!$result || !$this->RbacToken->isValidToken($token)) {
            $this->Flash->error('Token no es válido o ha expirado.');
            return $this->redirect(['plugin' => 'Rbac', 'controller' => 'RbacUsuarios', 'action' => 'login']);
        }

        if (!empty($result)) {
            $fecha_actual   = strtotime('now');
            $fecha_creacion = strtotime($result->created);
            $minutos        = ($fecha_actual - $fecha_creacion) / 60;

            $id   = $result->rbac_usuario_id;
            $user = $this->RbacUsuarios->get($id);
            if ($this->getRequest()->is('post')) {

                $user = $this->RbacUsuarios->patchEntity(
                    $user,
                    [
                        'password' =>  $this->getRequest()->getData('password'),
                        'password_confirm' =>  $this->getRequest()->getData('password_confirm')
                    ],
                    ['validate' => 'password']
                );

                if ($user->getErrors()) {
                    // Mostrar errores de validación
                    foreach ($user->getErrors() as $field => $errors) {
                        foreach ($errors as $error) {
                            $this->Flash->error(__($error));
                        }
                    }
                } else {
                    //$seed = $user->seed;
                    $seed = hash('sha256', 'ipmagna');
                    $password =  hash('sha256', $seed . $this->getRequest()->getData('password'));
                    $passwordConfirm =   hash('sha256', $seed . $this->getRequest()->getData('password_confirm'));
                    $this->RbacUsuarios->getConnection()->begin();
                    $user = $this->RbacUsuarios->patchEntity($user, [
                        'password' =>   $password,
                        'password_confirm' =>   $passwordConfirm,
                        'seed' => $seed,
                        'activo' => 1
                    ]);
                    //debug($user);die;
                    try {
                        if ($this->RbacUsuarios->save($user)) {
                            // Invalida el token después de usarlo
                            if ($this->RbacToken->delete($result)) {
                                $this->RbacUsuarios->getConnection()->commit();
                                Log::info("Password cambiado para el usuario ID: {$id}");
                                $this->Flash->success('El password se estableció correctamente');
                                return $this->redirect(['plugin' => 'Rbac', 'controller' => 'RbacUsuarios', 'action' => 'login']);
                            } else {
                                throw new \Exception('No se pudo eliminar el token.');
                            }
                        } else {
                            throw new \Exception('No se pudo guardar el password.');
                        }
                    } catch (\Exception $e) {
                        $this->RbacUsuarios->getConnection()->rollback();
                        Log::error("Error al cambiar el password para el usuario ID: {$id}. Error: " . $e->getMessage());
                        $this->Flash->error('Ocurrió un error al cambiar el password.');
                    }
                }
            }
            $this->set(compact('user', 'token'));
        } else {
            return $this->redirect(['plugin' => 'Rbac', 'controller' => 'RbacUsuarios', 'action' => 'login']);
        }
    }

    /**
     * Si el usuario ovlido su contraseña, el sistema envia un mail con un token (24 horas) que permite crear una nueva contreseña.
     */
    public function forgetPassword()
    {
        $configuraciones = $this->fetchTable('Rbac.Configuraciones');
        $configuracionCaptcha        = $configuraciones->findByClave('Mostrar Captcha')->first();
        $this->set('captcha', $configuracionCaptcha->valor);

        if ($this->getRequest()->is('post')) {

            $data = $this->getRequest()->getData();
            $validator = new Validator();
            // Definir las reglas de validación
            $validator
                ->email('usuario', false, 'El campo usuario debe ser una dirección de correo válida.')
                ->notEmptyString('usuario', 'El campo usuario no puede estar vacío.');

            // Validar los datos
            $errors = $validator->validate($data);

            if (!empty($errors)) {
                foreach ($errors as $field => $fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        $this->Flash->error(__($error));
                    }
                }
            } else {

                if ($configuracionCaptcha->valor == 'Si') {
                    $recaptcha = $this->request->getData('g-recaptcha-response');

                    $http = new Client();
                    $response = $http->post('https://www.google.com/recaptcha/api/siteverify', [
                        'secret' => env('RECAPTCHA_CLAVE_SECRETA'),
                        'response' => $recaptcha,
                    ]);
                    $result = json_decode($response->getBody(), true);
                } else {
                    $result['success'] = true;
                }

                if ($result['success']) {

                    $usuario = $this->RbacUsuarios->find()->where(['usuario' => $data['usuario']])->first();

                    if (!empty($usuario)) {

                        $token = $this->generateToken();

                        $RbacToken = $this->fetchTable('Rbac.RbacToken');
                        $data['token']      = $token;
                        $data['rbac_usuario_id'] = $usuario->id;
                        $data['validez']    = 1440;
                        $rbacToken = $RbacToken->newEntity($data);

                        $datos               = array();
                        $datos['subject']    = 'Confirmación de registro nuevo usuario';
                        $datos['url'] = Router::url('/', true) . "rbac/rbac_usuarios/changePassword/" . $token;
                        $datos['aplicacion'] = "IPMAGNA";
                        $datos['template']   = 'recover_password';
                        $datos['email']      = $this->getRequest()->getData('usuario');

                        $RbacToken->getConnection()->begin();
                        if ($RbacToken->save($rbacToken)) {
                            if ($this->sendEmail($datos)) {
                                $RbacToken->getConnection()->commit();
                                $this->Flash->success('Se ha enviado la información a ' . $data['usuario'] . ' para crear el password de su usuario. Por favor, ingrese al enlace que se encuentra en la descripción del email');
                            } else {
                                $RbacToken->getConnection()->rollback();
                                $this->Flash->error('No se pudo enviar el email de recuperación de contraseña');
                            }
                        } else {
                            $this->RbacToken->getConnection()->rollback();
                            $this->Flash->error('No se pudo generar token para enviar el email de recuperación de contraseña');
                        }
                    } else {
                        $this->Flash->error('El usuario no se encuentra registrado.');
                    }
                } else {
                    $this->Flash->error('Error con la configuración de recaptcha ' . $result);
                }
            }
        }
    }

    /**
     * Permite modificar la contraseña del usuario
     */
    public function changePassword($token)
    {

        $this->RbacToken = $this->fetchTable('Rbac.RbacToken');
        //$this->loadModel('Rbac.RbacToken');
        $result = $this->RbacToken->find()->where(['token' => $token])->first();

        if (!empty($result)) {
            $fecha_actual   = strtotime('now');
            $fecha_creacion = strtotime($result->created);
            $minutos        = ($fecha_actual - $fecha_creacion) / 60;

            if ($minutos < strtotime($result->validez)) {
                $id   = $result->rbac_usuario_id;
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
                //debug($user);
                $this->set(compact('user', 'token'));
            } else {
                $this->redirect(array('controller' => 'rbac_usuarios', 'action' => 'login', 1));
            }
        } else {
            $this->redirect(array('controller' => 'rbac_usuarios', 'action' => 'login', 1));
        }
    }

    private function generateToken($length = 24)
    {
        if (function_exists('openssl_random_pseudo_bytes')) {
            $token = base64_encode(openssl_random_pseudo_bytes($length, $strong));
            if ($strong == TRUE) {
                return strtr(substr($token, 0, $length), '+/=', '-_,');
            }
        }

        //php < 5.3 or no openssl
        $characters = '0123456789';
        $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz+';
        $charactersLength = strlen($characters) - 1;
        $token            = '';

        //select some random characters
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[mt_rand(0, $charactersLength)];
        }

        return $token;
    }
}
