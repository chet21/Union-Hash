<?php
/**
 * Created by PhpStorm.
 * User: user 1
 * Date: 03.12.2017
 * Time: 12:59
 */

namespace Lib\Coin;

use App\Configuration\Conf;
use System\DB;


abstract class CoinBase
{
    protected $conf;
    protected $connection;

    public function __construct()
    {
        $this->conf = Conf::init();
        $this->connection = DB::connection();
    }
}