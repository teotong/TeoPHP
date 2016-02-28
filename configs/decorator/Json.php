<?php
namespace configs\decorator;

use TeoPHP\Application;

class Json
{
    function beforeRequest($route_address)
    {

    }

    function afterRequest($return_value)
    {
        if (!empty($return_value)) {
            //如果存在return
            $output = '';
            if (isset($_GET['return'])) {
                $output = $_GET['return'];
            }
            $json = Application::getJson($return_value);
            switch ($output) {
                case 'jsonp' :
                    //为了支持跨域操作
                    $js_callback = "callback";
                    $json->returnJsonp($js_callback);
                    break;
                default :
                    //默认api都返回json格式
                    $json->returnJson();
                    break;
            }
        }

    }
}