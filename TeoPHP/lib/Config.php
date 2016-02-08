<?php

namespace TeoPHP\lib;

class Config implements \ArrayAccess
{
    private static $_instance;
    private $path;
    private $configs = array();

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function offsetGet($offset)
    {
       if (empty($this->configs[$offset])) {
           $file_path = $this->path . '/' . $offset . '.php';
           if (!file_exists($file_path)) {
               throw new \Exception('config '. $offset . ' is not found');
           }
           $value = require $file_path;
           $this->configs[$offset] = $value;
       }
        return $this->configs[$offset];
    }

    public function offsetExists($offset)
    {
        return isset($this->configs[$offset]);
    }

    public function offsetSet($offset, $value)
    {
        throw new \Exception('cannot write config file.');
    }

    public function offsetUnset($offset)
    {
        unset($this->configs[$offset]);
    }

    /**
     * 入口
     * @param $config_path
     * @return Config
     */
    public static function setConfigPath($config_path)
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self($config_path);
        }
        return self::$_instance;
    }

}