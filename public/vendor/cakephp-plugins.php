<?php
$baseDir = dirname(dirname(__FILE__));

return [
    'plugins' => [
        'AdminLTE' => $baseDir . '/plugins/AdminLTE/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'Cake/TwigView' => $baseDir . '/vendor/cakephp/twig-view/',
        'Db' => $baseDir . '/plugins/Db/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'Rbac' => $baseDir . '/plugins/Rbac/',
    ],
];
