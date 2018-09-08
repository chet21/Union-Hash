<?php
/**
 * Created by PhpStorm.
 * User: user 1
 * Date: 25.05.2017
 * Time: 11:32
 */

namespace System;


class Error
{
    static public function E404(){
        header('HTTP/1.1 404');
        exit(include __DIR__ . '/../src/404.php');
    }
}