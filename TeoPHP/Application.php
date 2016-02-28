<?php

namespace TeoPHP;

/**
 * 工厂模式 所有基础类的实例化入口
 * Class Application
 * @package TeoPHP
 */
class Application
{
    /**
     * 获得配置
     * @param $config_name
     * @param null $config_path
     * @return mixed
     */
    public static function getConfig($config_name, $config_path = null)
    {
        $config_path = !empty($config_path) ? $config_path : BASEDIR . '/configs';
        $config = \TeoPHP\lib\Config::setConfigPath($config_path);
        return $config[$config_name];
    }

    /**
     * 获得数据库
     * @param $db
     * 数据库类型 主库还是副库 master or slave
     * @param $db_type
     * @param bool $p_connect
     * @param null $timeout
     * @param null $charset
     * @return mixed
     */
    public static function getMysql($db, $db_type, $p_connect = false, $timeout = null, $charset = null)
    {
        return \TeoPHP\lib\MySQL::connect($db, $db_type, $p_connect, $timeout, $charset);
    }

    /**
     * 运行程序
     * @param $action
     * @param string $folder api or contorller or interface
     */
    public static function run($route_address, $folder = 'api')
    {
        if ($folder == 'interface') {
            $class = '\\interface\\' . $route_address[0];
        } else {
            $class = '\\controllers\\' . $folder . '\\' . $route_address[0];
        }
        try {
            $req = \TeoPHP\lib\Request::getInstance();
            $a = new $class($route_address, $req);
            return $a->doAction();
        } catch (\Exception $ex) {
            #TODO 记日志 coding....
        }
    }

    /**
     * xss过滤(一般用作富文本) voku/anti-xss
     * @param $harm_string
     * @return array|bool|string
     */
    public static function getXss($harm_string)
    {
        $antiXss = new \voku\helper\AntiXSS();
        return $antiXss->xss_clean($harm_string);
    }

    /**
     * 日志类 monolog/monolog
     * @param $class
     * @return \Monolog\Logger
     */
    public static function getLogger($class)
    {
        $config = self::getConfig('resource');
        // create a log channel
        $log = new \Monolog\Logger($class);
        $log->pushHandler(new \Monolog\Handler\StreamHandler($config['logpath']['path']));
        return $log;
    }

    /**
     * curl类 php-curl-class/php-curl-class
     * @return \Curl\Curl
     */
    public static function getCurl()
    {
        return new \Curl\Curl();
    }

    /**
     * json类
     * @param array $data
     * @param string $code
     * @param string $msg
     * @return lib\JsonLib
     */
    public static function getJson($data = array(), $code = '', $msg = '')
    {
        return new \TeoPHP\lib\JsonLib($data, $code, $msg);
    }

    public static function getTemplate($address)
    {
        return \TeoPHP\lib\TemplateLib::getInstance($address);
    }

}