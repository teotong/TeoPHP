<?php

namespace controllers\app\index;

use TeoPHP\Controller;

class Index extends Controller
{
    public $params = array(
        'entid' => array(
            'mustexist' => true,
            'notnull'   => true,
            'preg_type' => 'int',
            'min' => 1,
            'error_code'=> 10001,
        ),
        /*
        'class' => array(
            'mustexist' => true,
            'notnull'   => true,
            'preg_type' => 'int',
            'min' => 0,
            'error_code'=> 10002,
        ),
        'mailstatus' => array(
            'mustexist' => true,
            'notnull'   => true,
            'preg_type' => 'int',
            'min' => 0,
            'error_code'=> 10003,
        ),
        'type' => array(
            'mustexist' => true,
            'notnull'   => true,
            'preg_type' => 'int',
            'min' => 0,
            'error_code'=> 10008,
        ),
        'caseid' => array(
            'mustexist' => true,
            'notnull'   => true,
            'error_code'=> 10008,
        ),
        'to' => array(
            'mustexist' => true,
            'notnull'   => true,
            'error_code'=> 10008,
        ),
        'title' => array(
            'mustexist' => true,
            'notnull'   => true,
            'lengthmin' => 1,
            'lengthmax' => 70,
            'error_code'=> 10008,
        ),
        'body' => array(
            'mustexist' => true,
            'xss' => false,
            'error_code'=> 10008,
        ),
        'sendusername' => array(
            'mustexist' => true,
            'notnull'   => true,
            'lengthmin' => 1,
            'lengthmax' => 20,
            'error_code'=> 10008,
        ),
        'createtime' => array(
            'mustexist' => true,
            'notnull'   => true,
            'preg_type' => 'int',
            'min' => 0,
            'error_code'=> 10008,
        ),
        'senduserid' => array(
            'mustexist' => true,
            'notnull'   => true,
            'preg_type' => 'int',
            'min' => 1,
            'error_code'=> 10009,
        ),
        */
    );

    public function doAction()
    {
//        $req = $this->getRequest();
        $req = $this->getRequest('html', array('index/index', array('display'=>'cuowu')));
//        Application::getMysql('test', 'slave')->prepare('SELECT * FROM `test`');
//        Application::getLogger(__CLASS__. ':' .__LINE__)->addError('message' , '(array)data');
        return array(
            'display' => $req->entid
        );
    }

}