<?php

namespace App\Configuration;

class BaseConfiguration
{
    public $data;

    public function load($file)
    {
        $this->data = require $file;

    }

    public function set($key, $val)
    {
        $this->data[$key] = $val;

    }

    public function get($key)
    {
        foreach ($this->data as $k => $v){
            if($k == $key){
                $res = $v;
            }
        }
        return $res;
    }
}