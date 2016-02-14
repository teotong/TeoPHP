<?php

namespace controllers\app\index;

use TeoPHP\Controller;
use TeoPHP\Application;

class Login extends Controller
{
    public function doAction()
    {
        $a = Application::getConfig('resource');
        var_dump($a);
    }
}