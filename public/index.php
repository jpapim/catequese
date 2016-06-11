<?php
chdir(dirname(__DIR__));

define('ZF_CLASS_CACHE', 'data/cache/classes.php.cache');
if (file_exists(ZF_CLASS_CACHE)) {
    require_once ZF_CLASS_CACHE;
}

set_time_limit(360);

date_default_timezone_set('America/Sao_Paulo');

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

//Define o application_env
define('APPLICATION_ENV', (isset($_SERVER['APPLICATION_ENV'])) ? $_SERVER['APPLICATION_ENV'] : 'development');
define('BASE_PATCH', str_replace('\public', '', __DIR__));
define('BASE_URL', $_SERVER['HTTP_HOST']);

if (APPLICATION_ENV == 'development') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

// Alysson - Importando arquivo de Constantes
require 'infra/constantes.php';
require 'infra/debug.php';

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
