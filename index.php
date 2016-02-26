<?php

define('BASEDIR', __DIR__);
require BASEDIR . '/TeoPHP/Loader.php';
spl_autoload_register('\\TeoPHP\\Loader::autoload');

if (!is_readable('vendor')) {
    die('please composer install frist');
}
require 'vendor/autoload.php';
require 'tools/helper.php';

$route = new \TeoPHP\lib\Route();
$route->run();

if ($folder == 'app') {
    $return = new \configs\decorator\Template();
} else {
    $return = new \configs\decorator\Json();
}
//$return = \TeoPHP\Application::run($address, $folder);
//echo $decorator;exit;
//$return = \TeoPHP\Application::getConfig($decorator, BASEDIR . '/configs/decorator');
//print_r($return);exit;
$return->beforeRequest($address);
$return_value = \TeoPHP\Application::run($address, $folder);
$return->afterRequest($return_value);









