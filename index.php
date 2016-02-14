<?php

define('BASEDIR', __DIR__);
require BASEDIR . '/TeoPHP/Loader.php';
spl_autoload_register('\\TeoPHP\\Loader::autoload');

if (!is_readable('vendor')) {
    die();
}
require 'vendor/autoload.php';

$a =  explode('/', preg_replace('/^\//', '', $_SERVER['PATH_INFO'], 1));
$action_num = count($a);
if ($action_num == 1) {
    //对内api接口
    //访问例如：http://framework.mytest.com/add_folder?a=bb
    $folder = 'api';
    $action = $a[0];
    $action = strtolower(str_replace('_', '', trim($action)));
} elseif ($action_num == 2) {
    //web应用程序
    //访问例如：http://framework.mytest.com/index/index?a=bb
    $folder = 'app';
    $action = implode('\\', $a);
    $action = strtolower(trim($action));
} else {
    header('HTTP/1.1 404 Not Found');
    exit;
}
$actionsMap = \TeoPHP\Application::getConfig('route_' . $folder);

if (!array_key_exists($action, $actionsMap)) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
\TeoPHP\Application::run($actionsMap[$action][0], $folder);









