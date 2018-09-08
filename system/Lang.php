<?php

namespace System;

class Lang
{
    private $data;

    function __construct($part)
    {
        $this->load($part);
    }

    private function load($file)
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
                return $v;
            }
        }
    }

    public function get_list()
    {
        return $this->data;
    }
}