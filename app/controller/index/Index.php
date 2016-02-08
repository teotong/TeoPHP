<?php

namespace app\controller\index;

use TeoPHP\Controller;
use TeoPHP\Application;

class Index extends Controller
{
    private $params = array(
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
        $returnArr = Application::verifyParam($_REQUEST, $this->params);
        if($returnArr['code'] != 10000) {
            Application::getLogger(__CLASS__. ':' .__LINE__)->addError('Parameter error' , $returnArr);
//            $this->writeLog('test', false, '测试1111', $encode, 'debug');
//            $noticeMsg = $this->getNoticeMsg($returnArr[1]['code']);
//            $this->writeLog('mail', false, $noticeMsg, array($post, $returnArr[1]['data']), 'warning', 'lognum1');
//            data_return($returnArr[1]['code'], $returnArr[1]['data']);
        }
        $this->data = $returnArr['data'];
//        var_dump($this->data);exit;

        Application::getMysql('test', 'slave')->prepare('SELECT * FROM `test`');

    }

    public function getResultData() {
        return array(

        );
    }
}