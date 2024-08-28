<?php
use Cake\Core\Configure;


if (!Configure::check('Theme.title')) {
    Configure::write('Theme.title', 'IPMagna');
}

if (!Configure::check('Theme.logo.mini')) {
    Configure::write('Theme.logo.mini', '<img src="/img/logo-ipmagna.png" style="margin: 5px 25%;" alt="">');
}

if (!Configure::check('Theme.logo.large')) {
    Configure::write('Theme.logo.large', ' <img src="/img/logo-ipmagna.png">');
}

if (!Configure::check('Theme.login.show_remember')) {
    Configure::write('Theme.login.show_remember', true);
}

if (!Configure::check('Theme.login.show_register')) {
    Configure::write('Theme.login.show_register', true);
}

if (!Configure::check('Theme.login.show_social')) {
    Configure::write('Theme.login.show_social', false);
}

if (!Configure::check('Theme.folder')) {
    Configure::write('Theme.folder', ROOT);
}

if (!Configure::check('Theme.skin')) {
    Configure::write('Theme.skin', 'blue');
}
