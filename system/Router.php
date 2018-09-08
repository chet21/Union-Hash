<?php

namespace System;

use System\Error;

class Router
{

    public $routs;
    public $uri;

    public function __construct()
    {
        $this->routs = include __DIR__ . '/../var/routs.php';
        $this->uri = trim($_SERVER['REQUEST_URI'], '/');
    }

    public function Run()
    {
        foreach ($this->routs as $key => $rout){

            if(preg_match("~^$key$~", $this->uri)){
                $part = preg_replace("~$key~", $rout, $this->uri);
                $elements = explode('/', $part);
                $controller = ucfirst($elements[0]).'Controller';
                $controller_namespace = 'App\\Controllers\\'.$controller;
                $action = ucfirst($elements[1]).'Action';
                $param1 = ($elements[2]) ? $elements[2] : null;
                $param2 = ($elements[3]) ? $elements[3] : null;

                if (file_exists(__DIR__.'/../app/controllers/'.$controller.'.php')) {
                    $page_object = new $controller_namespace();
                    return $page_object->$action($param1, $param2);
                }
            }
        }
        Error::E404();
    }
}

