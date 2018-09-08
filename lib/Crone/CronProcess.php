<?php
/**
 * Created by PhpStorm.
 * User: user 1
 * Date: 03.12.2017
 * Time: 10:19
 */

namespace lib\Crone;

use Lib\Coin\CoinEth;
use System\DB;

class CronProcess
{
    private $c;

    public function __construct()
    {
        $this->c = DB::connection();
    }
    public function revision_eth()
    {
        $data_db = $this->c
            ->query("SELECT power FROM system_hashrate WHERE title = 'eth'")
            ->fetchAll(\PDO::FETCH_ASSOC);

        $coin = new CoinEth();
        $power_now =  $coin->miner_hash_power();

        if($power_now > $data_db[0]['power']){
            $this->c
                ->query("UPDATE system_hashrate SET power = $power_now WHERE title = 'eth'");
        }
        return $power_now;
    }
}