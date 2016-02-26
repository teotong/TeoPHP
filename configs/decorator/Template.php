<?php
namespace configs\decorator;

use TeoPHP\Application;

class Template
{
    private $address;

    public function beforeRequest($address)
    {
        $this->address = $address;
    }

    public function afterRequest($return_value)
    {
        if (!empty($return_value)) {
            Application::getTemplate($this->address)->display('', $return_value);
        }
    }
}