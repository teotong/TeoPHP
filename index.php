<?php

define('BASEDIR', __DIR__);
require BASEDIR . '/TeoPHP/Loader.php';
spl_autoload_register('\\TeoPHP\\Loader::autoload');

if (!is_readable('vendor')) {
    die('please run `composer install` first');
}
require 'vendor/autoload.php';
require 'tools/helper.php';

$route = new \TeoPHP\lib\Route();
$route_lib = $route->run();

if ($route_lib->getFolder() == 'app') {
    $return = new \configs\decorator\Template();
} else {
    $return = new \configs\decorator\Json();
}

$return->beforeRequest($route_lib->getRouteAddress());
$return_value = \TeoPHP\Application::run($route_lib->getRouteAddress(), $route_lib->getFolder());
$return->afterRequest($return_value);









