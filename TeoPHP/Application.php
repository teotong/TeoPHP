<?php

namespace TeoPHP;

/**
 * 工厂模式 所有基础类的实例化入口
 * Class Application
 * @package TeoPHP
 */
class Application
{

    private static $antiXss;    //xss过滤类
    private static $log;    //日志类
    private static $curl;   //curl类

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
    public static function run($action, $folder = 'api')
    {
        if ($folder == 'interface') {
            $class = '\\interface\\' . $action;
        } else {
            $class = '\\app\\' . $folder . '\\' . $action;
        }
        try {
            $a = new $class;
            $a->doAction();
        } catch (\Exception $ex) {

        }
    }

    /**
     * xss过滤(一般用作富文本) voku/anti-xss
     * @param $harm_string
     * @return array|bool|string
     */
    public static function xss_clean($harm_string)
    {
        if (!self::$antiXss) {
            self::$antiXss = new \voku\helper\AntiXSS();
        }
        $harmless_string = self::$antiXss->xss_clean($harm_string);
        return $harmless_string;
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
        if (!self::$log) {
            self::$log = new \Monolog\Logger($class);
            self::$log->pushHandler(new \Monolog\Handler\StreamHandler($config['logpath']['path']));
        }
        return self::$log;
    }

    /**
     * curl类 php-curl-class/php-curl-class
     * @return \Curl\Curl
     */
    public static function curl()
    {
        if (!self::$curl) {
            self::$curl = new \Curl\Curl();
        }
        return self::$curl;
    }

    /**
     * 参数验证类
     * @param $data
     * @param $verifyArr
     * @param bool $xss xss过滤,是否执行htmlspecialchars 默认开启xss
     * @return array
     */
    public static function verifyParam($data, $verifyArr, $xss = true)
    {
        $returnArr = \TeoPHP\lib\Security::getInstance($data, $verifyArr, $xss)->verifyParam();
        return $returnArr;
    }

}