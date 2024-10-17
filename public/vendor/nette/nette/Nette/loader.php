<?php

/**
 * Nette Framework (version 2.1.13 released on 2020-08-25, https://nette.org)
 *
 * Copyright (c) 2004, 2015 David Grudl (https://davidgrudl.com)
 */


// deprecated
define('NETTE', TRUE);
define('NETTE_DIR', __DIR__);
define('NETTE_VERSION_ID', 20113);


// Run NetteLoader
require_once __DIR__ . '/common/exceptions.php';
require_once __DIR__ . '/common/Object.php';
require_once __DIR__ . '/Loaders/NetteLoader.php';

Nette\Loaders\NetteLoader::getInstance()->register();


require_once __DIR__ . '/common/shortcuts.php';
