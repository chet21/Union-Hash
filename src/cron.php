<?php

use lib\Crone\CronProcess;
use App\Configuration\Conf;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../lib/Parser/ParseCoinCurs.php';

Conf::init()->load(__DIR__.'/../var/config.php');


//$z = new CronProcess();
//$z->revision_eth();

$new_course = new \Lib\Parser\ParseCoinCurs();
$new_course->pars_courses();


