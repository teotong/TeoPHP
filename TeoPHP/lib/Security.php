<?php

namespace TeoPHP\lib;

class Security
{
    //保存类实例的静态成员变量
    private static $_instance;

    private $data = array();
    private $verifyArr = array();
    private $xss;
    private $charCode = 'UTF-8';

    /*
     * 例子：
    public $params = array(
        'mail' => array(
            'mustexist' => true,
            'notnull'   => true,
            'xss'       => true,    //默认开启
            'preg_type' => 'int',
            'preg_match'=> '正则',
            'min'       => 1,
            'max'       => 46,
            'lenthmin'  => 1,
            'lenthmax'  => 46,
            'error_code'=> 100010,
        )
    );
    */

    private function __construct($data, $verifyArr ,$xss)
    {
        $this->data = $data;
        $this->verifyArr = $verifyArr;
        $this->xss = $xss;
    }


    //创建__clone方法防止对象被复制克隆
    public function __clone()
    {
        trigger_error('Clone is not allow!',E_USER_ERROR);
    }

    //单例方法,用于访问实例的公共的静态方法
    public static function getInstance($data, $verifyArr ,$xss = true)
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self($data, $verifyArr ,$xss);
        }
        return self::$_instance;
    }

    //检查是否必须存在以及是否为空
    private function verifyMust()
    {
        foreach ($this->verifyArr as $key => $val) {
            //去除两边空格
            if (isset($this->data[$key])) {
                $this->data[$key] = trim($this->data[$key]);
            }

            //检验是否缺少参数
            if (isset($val['mustexist'])) {
                if (!isset($this->data[$key])) {
                    return $key;
                }
            }

            //检验是否为空
            if (isset($val['notnull']) && isset($this->data[$key])) {
                //$data[$key] === ''因为有0的存在
                if ($this->data[$key] === '') {
                    return $key;
                }

            }
        }
    }


    /**
     * 校验规则
     * @return array|bool
     */
    private function verifyRule()
    {
        foreach ($this->data as $key => $val) {
            if (isset($this->verifyArr[$key]) && $val !== '') {
                if (isset($this->verifyArr[$key]['preg_type'])) {

                    switch ($this->verifyArr[$key]['preg_type']) {
                        //检验是否为数字 例如:012或者字符串'233'
                        case 'int' :
                            if (!(is_numeric($val) && is_int($val + 0))) {
                                return $key;
                            }
                        break;
                        //检验ip
                        case 'ip' :
                            if (!filter_var($val, FILTER_VALIDATE_IP)) {
                                return $key;
                            }
                        break;
                        //检验email
                        case 'email' :
                            if (!filter_var($val, FILTER_VALIDATE_EMAIL)) {
                                return $key;
                            }
                        break;
                        //检验url
                        case 'url' :
                            if (!filter_var($val, FILTER_VALIDATE_URL)) {
                                return $key;
                            }
                        break;

                        default :
                        break;

                    }
                }

                //检验正则
                if (isset($this->verifyArr[$key]['preg_match'])) {
                    if (!preg_match($this->verifyArr[$key]['preg_match'], $val)) {
                        return $key;
                    }
                }

                //检验最小值
                if (isset($this->verifyArr[$key]['lengthmin'])) {
                    if (iconv_strlen($val, $this->charCode) < $this->verifyArr[$key]['lengthmin']) {
                        return $key;
                    }
                }

                //检验最大值
                if (isset($this->verifyArr[$key]['lengthmax'])) {
                    if (iconv_strlen($val, $this->charCode) > $this->verifyArr[$key]['lengthmax']) {
                        return $key;
                    }
                }

                //检验最小值
                if (isset($this->verifyArr[$key]['min'])) {
                    if ($val < $this->verifyArr[$key]['min']) {
                        return $key;
                    }
                }

                //检验最大值
                if (isset($this->verifyArr[$key]['max'])) {
                    if ($val > $this->verifyArr[$key]['max']) {
                        return $key;
                    }
                }

                //是否需要xss转义
                if ($this->xss) {
                    if(isset($this->verifyArr[$key]['xss'])) {
                        if($this->verifyArr[$key]['xss'] === true) {
                            $this->data[$key] = htmlspecialchars($val);
                        }
                    } else {
                        $this->data[$key] = htmlspecialchars($val);
                    }
                }
            }
        }

    }

    /**
     * 校验参数 默认开启xss
     * @param $data
     * @param $verifyArr
     * @param bool $xss xss过滤,是否执行htmlspecialchars
     * @return array
     */
    public function verifyParam()
    {
        //检查是否必须存在以及是否为空
        $verifyMust = $this->verifyMust();
        if (!empty($verifyMust)) {
            return array('code' => $this->verifyArr[$verifyMust]['error_code'], 'data' => $verifyMust);
        }

        //校验规则
        $verifyRule = $this->verifyRule();
        if (!empty($verifyRule)) {
            return array('code' => $this->verifyArr[$verifyRule]['error_code'], 'data' => $verifyRule);
        }

        return array('code' => 10000, 'data' => $this->data);
    }
}
