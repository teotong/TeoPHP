<?php
namespace TeoPHP;

abstract class Controller
{

    public function __construct($address, $req)
    {
        $this->address = $address;
        $this->request = $req;
    }

    public function assign($key, $value)
    {
        Application::getTemplate($this->address)->assign($key, $value);
    }

    public function display($file = '', $return_value = array())
    {
        Application::getTemplate($this->address)->display($file, $return_value);
    }


    public function getRequest($type = 'json', $return_array = array())
    {
        $data_class = Application::getVerify($_REQUEST, $this->params);
        if($data_class->getErrorCode()) {
            Application::getLogger(__CLASS__. ':' .__LINE__)->addError('Parameter error' , $data_class->getErrorData());
            if ($type = 'html') {
                Application::getTemplate($this->address)->display($return_array[0], $return_array[1]);
            } else {
                Application::getJson(array($data_class->getErrorParam()), $data_class->getErrorCode(), 'Parameter error')->returnJson();
            }
        }
        return $this->request;
    }

    abstract protected function doAction();
}