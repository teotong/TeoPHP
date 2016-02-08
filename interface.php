<?php

//接口
define('BASEDIR', __DIR__);
require BASEDIR . '/TeoPHP/Loader.php';
spl_autoload_register('\\TeoPHP\\Loader::autoload');

if (!is_readable('vendor')) {
    die();
}
require 'vendor/autoload.php';

$a =  explode('/', preg_replace('/^\//', '', $_SERVER['PATH_INFO'], 1));
$action = implode('\\', $a);
$action = strtolower(trim($action));

$actionsMap = \TeoPHP\Application::getConfig('route_interface');
if (!array_key_exists($action, $actionsMap)) {
    header('HTTP/1.1 404 Not Found');
    exit;
}

\TeoPHP\Application::run($actionsMap[$action][0], $folder);