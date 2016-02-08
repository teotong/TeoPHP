<?php
namespace TeoPHP;

class Loader
{
    public static function autoload($class)
    {
//        echo BASEDIR .'/' . str_replace('\\', '/',$class ) . '.php';exit;
        require BASEDIR .'/' . str_replace('\\', '/',$class ) . '.php';
    }
}
