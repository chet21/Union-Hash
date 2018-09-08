<?php

namespace App\Configuration;

class Conf
{
    static private $config;

    private function __construct()
    {
    }

    static public function init()
    {
        if (self::$config == null){
            self::$config = new BaseConfiguration();
        }
        return self::$config;
    }
}