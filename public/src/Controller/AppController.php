<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\EventInterface;

use Cake\View\JsonView;
use Cake\Utility\Inflector;

//use Rbac\Controller\Component\Permisos;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
#[\AllowDynamicProperties]
class AppController extends Controller
{

    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Rbac.Permisos');



        // Configurar el componente de autenticación
        // $this->loadComponent('Auth', [
        //     'authenticate' => [
        //         'Form' => [
        //             'fields' => [
        //                 'username' => 'usuario',
        //                 'password' => 'password'
        //             ],
        //             'userModel' => 'Rbac.RbacUsuarios'
        //         ]
        //     ],
        //     'loginAction' => [
        //         'controller' => 'Rbac.RbacUsuarios',
        //         'action' => 'login'
        //     ],
        //     'logoutRedirect' => [
        //         'controller' => 'Rbac.RbacUsuarios',
        //         'action' => 'login'
        //     ],
        //     'authError' => 'No tienes permisos para acceder a esa página.',
        //     'checkAuthIn' => 'Controller.initialize'  // Verifica la autenticación en cada request
        // ]);
    }

    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        $session = $this->request->getSession();

        $perfilDefault = $session->read('PerfilDefault');
        $perfilesPorUsuario      = $this->getRequest()->getSession()->read('PerfilesPorUsuario');
        $accionesPermitidasPorPerfiles = $session->read('RbacAcciones');
        $usuario = $session->read('RbacUsuario');

        if (isset($accionesPermitidasPorPerfiles)) {
            $accionesPermitidas = $accionesPermitidasPorPerfiles;
        } else {
            $accionesPermitidas = NULL;
        }

        $session->write('permitidas', $accionesPermitidas);
        $this->set('accionesPermitidas', $accionesPermitidas);
        $this->set('perfilDefault', $perfilDefault);
        $this->set('usuario', $usuario);
        $this->set('perfilesPorUsuario', $perfilesPorUsuario);

        $this->viewBuilder()->setTheme('AdminLTE');

        $controller = Inflector::camelize($this->getRequest()->getParam('controller'));
        $action = Inflector::underscore($this->getRequest()->getParam('action'));

        if ($this->getRequest()->is('ajax')) {

            $this->viewBuilder()->setLayout('ajax');
        } else {

            //Si es login tiene el layout de login
            if ($this->getRequest()->getParam('action') == 'login') {
                //$this->viewBuilder()->setLayout('Rbac.login');
            } elseif (isset($accionesPermitidas[$controller][$action]) == 1) {

                if ($action == 'exportar') {
                    $this->viewBuilder()->setLayout('informe_excel');
                } else {

                    $this->viewBuilder()->setLayout('default');
                }
            }

        }
    }

    protected function getParamsKey($key)
    {
        return strtolower($this->getRequest()->getParam($key));
    }

    public function isAuthorized($user)
    {
        if (isset($user['usuario']))
            return true;
        else
            return false;
    }

    public function generateToken($length = 24)
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



    public static function secured_encrypt($data = null)
    {
        $firstKey = 'TjYkWzUHTCyPtAT/dshY1d5dfIYJjpGomVVN+GP9LWE=';
        $secondKey = 'akAdbgh2pykFl+6jKdiOHoHMLo3ZlFVeIv709H3L7OnEyNI40tRXBA6aVs0XauPAEb7OlTBdFYI0+GJNtKxJ6g==';
        $first_key = base64_decode($firstKey);
        $second_key = base64_decode($secondKey);
        $method = "aes-256-cbc";
        $iv_length = openssl_cipher_iv_length($method);
        $iv = openssl_random_pseudo_bytes($iv_length);
        $first_encrypted = openssl_encrypt($data, $method, $first_key, OPENSSL_RAW_DATA, $iv);
        //$second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);
        $second_encrypted = hash_hmac('sha512', $first_encrypted, $second_key, TRUE);
        $output = base64_encode($iv . $second_encrypted . $first_encrypted);
        return $output;
    }

    public static function secured_decrypt($input = null)
    {
        $firstKey = 'TjYkWzUHTCyPtAT/dshY1d5dfIYJjpGomVVN+GP9LWE=';
        $secondKey = 'akAdbgh2pykFl+6jKdiOHoHMLo3ZlFVeIv709H3L7OnEyNI40tRXBA6aVs0XauPAEb7OlTBdFYI0+GJNtKxJ6g==';
        $first_key = base64_decode($firstKey);
        $second_key = base64_decode($secondKey);
        $mix = base64_decode($input);
        $method = "aes-256-cbc";
        $iv_length = openssl_cipher_iv_length($method);
        $iv = substr($mix, 0, $iv_length);
        $second_encrypted = substr($mix, $iv_length, 64);
        $first_encrypted = substr($mix, $iv_length + 64);
        $data = openssl_decrypt($first_encrypted, $method, $first_key, OPENSSL_RAW_DATA, $iv);
        //$second_encrypted_new = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);
        $second_encrypted_new = hash_hmac('sha512', $first_encrypted, $second_key, TRUE);
        if (hash_equals($second_encrypted, $second_encrypted_new))
            return $data;
        return false;
    }
}
