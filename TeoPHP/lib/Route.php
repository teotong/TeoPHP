<?php
namespace TeoPHP\lib;

class Route
{
    private $config_path;

    public function __construct()
    {
        $this->config_path = BASEDIR . '/configs/route';
    }

    public function run()
    {
        $a =  explode('/', preg_replace('/^\//', '', $_SERVER['PATH_INFO'], 1));
        var_dump($a);exit;
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
        //从actionMap获得的地址 例如:index\\Index
        $this->address = $actionsMap[$action][0];

        return $this;
    }

    public function getAdress()
    {
        return $this->address;
    }

    public function getFolder()
    {
        return $this->folder;
    }
}