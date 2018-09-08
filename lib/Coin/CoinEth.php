<?php
/**
 * Created by PhpStorm.
 * User: user 1
 * Date: 03.12.2017
 * Time: 10:26
 */

namespace Lib\Coin;


use App\Configuration\Conf;
use System\DB;

class CoinEth extends CoinBase
//    implements CoinInterfase
{

    public function __construct()
    {
        parent::__construct();

    }

    private function all_eth_balance()
    {
        $x = file_get_contents('https://api.ethermine.org/miner/'.$this->conf->get('eth_wallet').'/payouts');
        $x = json_decode($x);

        $res = 0;
        foreach ($x as $val){
            foreach ($val as $item){
                $res =  $res + $item->amount;
            }
        }
        $out_early =  ($res/1000000000000000000);

        $z = file_get_contents('https://api.ethermine.org/miner/'.$this->conf->get('eth_wallet').'/currentStats');
        $z = json_decode($z);

        $current_balance =  ($z->data->unpaid/1000000000000000000);
        $all_eth = $out_early + $current_balance;
        return $all_eth;
    }


    public function update_eth_balance()
    {
        $d = date("Y-m-d");
        $s = $this->all_eth_balance();
        DB::connection()->query("INSERT INTO day_eth_stat (d, s) VALUE ($d, $s)");
    }

    public function different_current_last()
    {
        $for_day = 0;
        $current_sum = DB::connection()
            ->query("SELECT id, s FROM day_eth_stat WHERE id = ( SELECT MAX( id ) FROM day_eth_stat )")
            ->fetchAll(\PDO::FETCH_ASSOC);
        $c_sum = $current_sum[0]['s'];

        $l_id = (int)$current_sum[0]['id']-1;
        if($l_id >= 0){
            $last_sum = DB::connection()
                ->query("SELECT s FROM day_eth_stat WHERE id = $l_id")
                ->fetchAll(\PDO::FETCH_ASSOC);
            $last_sum = $last_sum[0]['s'];
            $for_day = $c_sum - $last_sum;
        }else{
            $for_day = $c_sum;
        }

        return  $for_day;
    }
    public function eth_per_one_mh($sum)
    {
        $system_hashrate = DB::connection()
            ->query("SELECT power FROM system_hashrate WHERE title = 'eth'")
            ->fetchAll(\PDO::FETCH_ASSOC);
        $system_hashrate = $system_hashrate[0]['power'];

        $res = $sum / $system_hashrate;
        return $res;
    }
    public function credit_eth_to_user($eth_per_one_mh)
    {
        $accounts = DB::connection()
            ->query("SELECT * FROM account WHERE user_hash_rate > 0")
            ->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($accounts as $val){
            $sum = ($eth_per_one_mh * $val['user_hash_rate']);
            $id = $val['user_id'];
            $fee = $sum * $this->conf->get('fee');
            $total = $sum - $fee;
            $this->connection->beginTransaction();
                $this->connection
                    ->query("INSERT INTO day_stat (user_id, eth, fee, total) VALUE ($id, $sum, $fee, $total)");
                $this->connection
                    ->query("UPDATE account SET balance = balance +$total WHERE user_id = $id");
            DB::connection()->commit();
        }

    }
    public function miner_hash_power()
    {
        $x = file_get_contents('https://api.ethermine.org/miner/'.$this->conf->get('eth_wallet').'/currentStats');
        $x = json_decode($x);

        $res = $x->data->reportedHashrate;
        $res = ceil($res / 1000000);
        return$res;
    }
}