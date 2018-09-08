<?php

namespace Helper;

class Hash
{
    public static function get()
    {
        $x = rand(1, 9999999999);
        return md5($x);
    }
}