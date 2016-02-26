<?php
namespace TeoPHP\lib;

use TeoPHP\Application;

class JsonLib
{
    private $data = array();
    //默认成功为10000
    private $code = 10000;
    private $msg = '';
    private $json_format = array();

    public function __construct($data = array(), $code = '', $msg = '')
    {
        $this->data = $data;
        $this->code = empty($code) ? $this->code : $code;
        $this->msg = $msg;

        $this->makeJsonFormat();
    }

    /**
     * 格式化json
     * @param array $data
     * @param string $code
     * @param string $msg
     * @return mixed
     */
    public function makeJsonFormat()
    {
        $this->json_format['code'] = $this->code;
        $this->json_format['data'] = $this->data;
        $this->json_format['msg'] = $this->msg;
    }

    /**
     * 输出son
     * @param array $data
     * @param string $code
     * @param string $msg
     */
    public function returnJson()
    {
        echo json_encode($this->json_format);exit;
    }

    /**
     * 输出jsonp
     * @param string $js_callback
     */
    public function returnJsonp($js_callback = 'callback')
    {
        //为了支持跨域操作
        if (Application::getRequest()->checkIEByUserAgent()) {
            //IE
            header('Content-type: text/javascript;charset=utf-8');
            //解决jsonp种cookie在ie浏览器下被拦截
            header("P3P: CP=CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR");
        } else {
            header('Content-type: application/javascript;charset=utf-8');
        }
        echo $js_callback . "(" . json_encode($this->json_format) . ");";exit;
    }
}
