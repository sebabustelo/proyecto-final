<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

//$this->layout = false;

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace templates/Pages/home.ctp with your own version or re-enable debug mode.'
    );
endif;

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Configuración de la Aplicación IPMAGA. Framework CakePHP <?= Configure::version() ?> Red Velvet.</h1>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="callout callout-info">
                <p>Tenga en cuenta que esta página no se mostrará si desactiva el modo de depuración (DEBUG=TRUE)  en el archivo .env.</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="callout callout-danger" id="url-rewriting">
                <?php Debugger::checkSecurityKeys(); ?>
                <p class="problem">URL rewriting is not properly configured on your server.</p>
                <p>
                    1) <a target="_blank" href="https://book.cakephp.org/4.0/en/installation.html#url-rewriting">Help me configure it</a>
                </p>
                <p>
                    2) <a target="_blank" href="https://book.cakephp.org/4.0/en/development/configuration.html#general-configuration">I don't / can't use URL rewriting</a>
                </p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php
            $class = 'callout-warning';

            if (version_compare(PHP_VERSION, '7.2.0', '>=') && extension_loaded('mbstring') && (extension_loaded('openssl') || extension_loaded('mcrypt')) && extension_loaded('intl')) {
                $class = 'callout-success';
            }
            ?>
            <div class="callout <?= $class ?>">
                <h4>Entorno</h4>
                <?php if (version_compare(PHP_VERSION, '7.2.0', '>=')): ?>
                    <p class="success">La versión de php es <?= PHP_VERSION ?>.</p>
                <?php else: ?>
                    <p class="problem">La versión de PHP es demasiado baja. Necesita PHP 7.2.0 o superior para usar CakePHP (detectado <?= PHP_VERSION ?>).</p>
                <?php endif; ?>

                <?php if (extension_loaded('mbstring')): ?>
                    <p class="success">La versión de php tiene la extensión mbstring cargada.</p>
                <?php else: ?>
                    <p class="problem">La versión de php no tiene la extensión mbstring cargada.</p>;
                <?php endif; ?>

                <?php if (extension_loaded('openssl')): ?>
                    <p class="success">La versión de php tiene la extensión extensión openssl cargada.</p>
                <?php elseif (extension_loaded('mcrypt')): ?>
                    <p class="success">La versión de php tiene la extensión extensión mcrypt cargada. </p>
                <?php else: ?>
                    <p class="problem">La versión de php no tiene la extensión openssl o mcrypt cargada.</p>
                <?php endif; ?>

                <?php if (extension_loaded('intl')): ?>
                    <p class="success">Your version of PHP has the intl extension loaded.</p>
                <?php else: ?>
                    <p class="problem">Your version of PHP does NOT have the intl extension loaded.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php
            $settings = Cache::getConfig('_cake_core_');
            $class = 'callout-warning';

            if (is_writable(TMP) && is_writable(LOGS) && !empty($settings)) {
                $class = 'callout-success';
            }
            ?>
            <div class="callout <?= $class ?>">
                <h4>Sistema de archivos</h4>
                <?php if (is_writable(TMP)): ?>
                    <p class="success">El directorio tmp tiene permiso de escritura.</p>
                <?php else: ?>
                    <p class="text-red">El directorio tmp no es tiene permisos de escritura writable.</p>
                <?php endif; ?>

                <?php if (is_writable(LOGS)): ?>
                    <p class="success">El directorio logs tiene permiso de escritura.</p>
                <?php else: ?>
                    <p class="text-red">El directorio logs no tiene permiso de escritura.</p>
                <?php endif; ?>

                <?php if (!empty($settings)): ?>

                    <p class="success">El <em><?= $settings['className'] ?>Engine</em>se utiliza para el almacenamiento en caché del núcleo. Para cambiar la configuración, edite config/app.php</p>
                <?php else: ?>
                    <p class="problem">La caché NO funciona. Comprueba la configuración en config/app.php</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php
            try {
                $connection = ConnectionManager::get('default');

                $connected = $connection;
            } catch (Exception $connectionError) {
                $connected = false;
                $errorMsg = $connectionError->getMessage();
                if (method_exists($connectionError, 'getAttributes')):
                    $attributes = $connectionError->getAttributes();
                    if (isset($errorMsg['message'])):
                        $errorMsg .= '<br />' . $attributes['message'];
                    endif;
                endif;
            }
            ?>
            <?php if ($connected): ?>
                <div class="callout callout-success">
                    <h4>Base de Datos</h4>
                    <p class="success">CakePHP puede conectarse a la base de datos.</p>
                </div>
            <?php else: ?>
                <div class="callout callout-danger">
                    <h4>Base de Datos</h4>
                    <p class="problem">CakePHP no puede conectarse a la base de datos.<br /><br /><?= $errorMsg ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php if (Plugin::isLoaded('DebugKit')): ?>
                <div class="callout callout-success">
                    <h4>DebugKit</h4>
                    <p class="success">DebugKit se cargo correctamente.</p>
                </div>
            <?php else: ?>
                <div class="callout callout-danger">
                    <h4>DebugKit</h4>
                    <p class="problem">DebugKit no pudo ser cargado. Necesita instalar pdo_sqlite o definir el nombre de conexión "debug_kit".</p>
                </div>
            <?php endif; ?>
        </div>;
    </div>




</section>
<!-- /.content -->
<?php
$this->Html->css('AdminLTE.debug', ['block' => 'css']);
?>
