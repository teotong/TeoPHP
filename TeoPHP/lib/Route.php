<?php
namespace TeoPHP\lib;

class Route
{
    private $config_path;
    private $folder;
    private $route_address;

    public function __construct()
    {
        $this->config_path = BASEDIR . '/configs/route';
    }

    public function run()
    {
        $a =  explode('/', preg_replace('/^\//', '', $_SERVER['PATH_INFO'], 1));
//        var_dump($a);exit;
        $action_num = count($a);
        if ($action_num == 1) {
            //对内api接口
            //访问例如：http://framework.mytest.com/add_folder?a=bb
            $this->folder = 'api';
            $action = $a[0];
            $action = strtolower(str_replace('_', '', trim($action)));
        } elseif ($action_num == 2) {
            //web应用程序
            //访问例如：http://framework.mytest.com/index/index?a=bb
            $this->folder = 'app';
            $action = implode('\\', $a);
            $action = strtolower(trim($action));
        } else {
            header('HTTP/1.1 404 Not Found');
            exit;
        }
        $actionsMap = \TeoPHP\Application::getConfig($this->folder, $this->config_path);

        if (!array_key_exists($action, $actionsMap)) {
            header('HTTP/1.1 404 Not Found');
            exit;
        }
//        var_dump($actionsMap[$action]);exit;
        //从actionMap获得的路由地址 即configs/route里的action地址 例如: array('index\\Index', true)
        $this->route_address = $actionsMap[$action];
        return $this;
    }

    public function getRouteAddress()
    {
        return $this->route_address;
    }


    public function getFolder()
    {
        return $this->folder;
    }
}