<?php

define('BASEDIR', __DIR__);
require BASEDIR . '/TeoPHP/Loader.php';
spl_autoload_register('\\TeoPHP\\Loader::autoload');

if (!is_readable('vendor')) {
    die();
}
require 'vendor/autoload.php';

/*
//xss过滤 voku/anti-xss
$harm_string = "Hello, i try to <script>alert('Hack');</script> your site";
$harmless_string = \TeoPHP\Application::xss_clean($harm_string);
var_dump($harmless_string);exit;
*/

/*
//记录日志例子 monolog/monolog
// add records to the log
\TeoPHP\Application::getLogger(__CLASS__)->addWarning('test' , array('1' => 'meiyou','2'));
exit;
*/

/*
//curl例子 php-curl-class/php-curl-class
\TeoPHP\Application::curl()->get('http://www.baidu.com/', array());
if (\TeoPHP\Application::curl()->error) {
    echo 'Error: ' . \TeoPHP\Application::curl()->errorCode . ': ' . \TeoPHP\Application::curl()->errorMessage;
    die();
}
echo \TeoPHP\Application::curl()->response;
exit;
*/

$a =  explode('/', preg_replace('/^\//', '', $_SERVER['PATH_INFO'], 1));
$action_num = count($a);
if ($action_num == 1) {
    //对内api接口
    //访问例如：http://test.mytest.com/add_folder?a=bb
    $folder = 'api';
    $action = $a[0];
    $action = strtolower(str_replace('_', '', trim($action)));
} elseif ($action_num == 2) {
    //web应用程序
    //访问例如：http://test.mytest.com/index/index?a=bb
    $folder = 'controller';
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









