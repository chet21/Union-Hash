<?php

use App\Configuration\Conf;
use System\Lang;

session_start();

//$w_ip = require_once __DIR__.'/white_ip.php';

//if(count($w_ip) > 0){
//    $x = in_array($_SERVER['REMOTE_ADDR'], $w_ip);
//    if(!$x){
//        include_once __DIR__.'/loader.html';
//        exit();
//    }
//}

//if(!is_dir(__DIR__.'/../vendor')){
//    exit('You must update composer');
//}

if($_COOKIE['lang'] == 0){
    setcookie('lang', 'ua', time() + 9999, '/');
}


require_once __DIR__.'/../system/rb.php';
require_once __DIR__.'/../vendor/autoload.php';


Conf::init()->load(__DIR__.'/../var/config.php');

$start = new \System\Router();
$start->Run();