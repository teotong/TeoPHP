<?php
namespace TeoPHP\lib;

class Request
{
    private static $_instance;
    public $data = array();

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : '';
    }


    /*
     * 获得某一请求的数据
     */
    public function getParam($name)
    {
        return isset($_REQUEST[$name]) ? $_REQUEST[$name] : '';
    }

    /**
     * 判断是否含有某一请求的数据
     * @param $name
     * @return bool
     */
    public function hasParam($name)
    {
        return isset($_REQUEST[$name]) ? true : false;
    }

    /**
     * 获得所有请求的数据
     * @return mixed
     */
    public function getParams()
    {
        return $_REQUEST;
    }

    /**
     * 获得某一post请求数据
     * @param $name
     * @return string
     */
    public function getPost($name)
    {
        return isset($_POST[$name]) ? trim($_POST[$name]) : '';
    }

    /**
     * 判断是否含有某一post请求数据
     * @param $name
     * @return bool
     */
    public function hasPost($name)
    {
        return isset($_POST[$name]) ? true : false;
    }

    /**
     * 获得所有post请求数据
     * @return mixed
     */
    public function getPosts()
    {
        return $_POST;
    }

    /**
     * 获得某一get请求数据
     * @param $name
     * @return string
     */
    public function getGet($name)
    {
        return isset($_GET[$name]) ? trim($_GET[$name]) : '';
    }

    /**
     * 判断是否含有某一get请求数据
     * @param $name
     * @return bool
     */
    public function hashGet($name)
    {
        return isset($_GET[$name]) ? true : false;
    }

    /**
     * 获得所有get请求数据
     * @return mixed
     */
    public function getGets()
    {
        return $_GET;
    }

    /**
     * 获得用户ip
     * @return mixed
     */
    public function getUserIp()
    {
        list($xip, $xinner) = $this->getValidIp(isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '');
        if ($xip && !$xinner) {
            return $xip;
        }

        list($ip, $inner) = $this->getValidIp(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
        if ($ip && !$inner) {
            return $ip;
        }

        if ($xip) {
            return $xip;
        } else {
            return $ip;
        }
    }

    /**
     * 判断ip是否为有效ip
     * @param $ip
     * @return array
     */
    public function getValidIp($ip) {
        if (preg_match_all('/\d{1,3}(\.\d{1,3}){3}/', $ip, $matches)) {
            foreach ($matches[0] as $sip) {
                if (preg_match('/^(127\.|10\.|172\.(1[6789]|2[0123456789]|3[01])\.|192\.168\.)/', $sip)) {
                    // inner ip
                } else {
                    return array($sip, false);
                }
            }
            return array($matches[0][0], true);
        }
        return array(false, false);

    }

    /**
     * 获得用户useragent
     * @return string
     */
    public function getUserAgent()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    }

    /**
     * 获得此次请求的方法类型
     * @return string
     */
    public function getRequestMethod()
    {
        return isset($_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : 'GET';
    }

    /**
     * 查看是否是苹果设备
     * @param int $version
     * @return bool
     */
    public function checkIosDeviceByUserAgent($version = 0)
    {
        $ua = $this->getUserAgent();
        if (preg_match('/(ipad|iphone|ipod)\s*;.*?os\s+(\d+)(_\d+)*/i', $ua, $matches)) {
            if ($version && $version > intval($matches[2])) {
                return false;
            }
            return true;
        }
        return false;

    }

    /**
     * 判断是否是手机设备
     * @return bool
     */
    public function checkSmartPhoneDeviceByUserAgent()
    {
        $ua = $this->getUserAgent();
        if (preg_match('/\b(iphone|ipad|ipod|android)\b/i', $ua) && preg_match('/applewebkit/i', $ua)) {
            return true;
        }
        return false;

    }

    /**
     * 判断是否是ipda
     * @param int $version
     * @return bool
     */
    public function checkPadDeviceByUserAgent($version = 0)
    {
        $ua = $this->getUserAgent();
        if (preg_match('/ipad\s*;.*?os\s+(\d+)(_\d+)*/i', $ua, $matches)) {
            if ($version && $version > intval($matches[1])) {
                return false;
            }
            return true;
        }
        return false;

    }

    /**
     * 判断是否是安卓设备
     * @param int $version
     * @return bool
     */
    public function checkAndroidDeviceByUserAgent($version = 0) {
        $ua = $this->getUserAgent();
        if (preg_match('/android\s+(\d+)(\.\d+)*/i', $ua, $matches)) {
            if ($version && $version > intval($matches[1])) {
                return false;
            }
            return true;
        }
        return false;

    }

    /**
     * 判断是否是ie浏览器
     * @return bool
     */
    public function checkIEByUserAgent()
    {
        $ua = $this->getUserAgent();
        //MSIE为ie浏览器 like Gecko为ie11浏览器
        if (preg_match("/MSIE|like Gecko/", $ua)) {
            return true;
        }
        return false;
    }

}