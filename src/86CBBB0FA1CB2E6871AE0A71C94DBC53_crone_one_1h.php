<?php

use lib\Crone\CronProcess;
use App\Configuration\Conf;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../lib/Parser/ParseCoinCurs.php';

Conf::init()->load(__DIR__.'/../var/config.php');


// Обновление баланса за прошедший час

$update_user_balance = new \Lib\Coin\CoinEth();
$update_user_balance->update_eth_balance();


// Начисление средств на счета за прошедший час
// Вычет комисси

$update = new \Lib\Coin\CoinEth();
$different_sum = $update->different_current_last();
$eth_per_on_MH = $update->eth_per_one_mh($different_sum);
$update->credit_eth_to_user($eth_per_on_MH);