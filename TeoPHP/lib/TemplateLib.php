<?php
namespace TeoPHP\lib;

class TemplateLib
{
    private $folder;
    private $data;
    private $tpl;
    private $template_dir = 'views/templates';
    private static $_instance;

    public function __construct($address)
    {
        list($this->folder, $this->tpl) = explode('\\', $address);
    }

    public static function getInstance($address)
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self($address);
        }
        return self::$_instance;
    }

    public function assign($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function display($file = '', $return_value = array())
    {
        $file = empty($file) ? $this->folder .'/'.strtolower($this->tpl).'.php' : $file . '.php';
        $path = BASEDIR . '/' . $this->template_dir .'/'. $file;
        $return_value = empty($return_value) ? $this->data : $return_value;
        extract($return_value);
        include $path;
        exit;
    }
}