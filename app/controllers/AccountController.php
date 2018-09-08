<?php
/**
 * Created by PhpStorm.
 * User: user 1
 * Date: 19.11.2017
 * Time: 23:58
 */

namespace App\Controllers;


use lib\Bitcoin;
use System\DB;
use System\Error;


class AccountController extends BaseController
{
    protected $hash;
    protected $login;
    protected $user_id;

    public function __construct()
    {
        parent::__construct();
        $this->login = $_SESSION['login'];
        $this->hash = $_SESSION['hash'];
        $this->user_id = $this->get_user_id();
        if($this->verification->check() == false) Error::E404();
    }

    //  PRIVATE functions
    private function get_user_id()
    {
        $id = $this->connection
            ->query("SELECT id FROM user WHERE login = '$this->login' AND hash = '$this->hash'")
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $id[0]['id'];
    }

    // PUBLIC functions
    public function dashboardAction()
    {
        $data = $this->connection
            ->query("SELECT * 
                               FROM day_stat
                               LEFT JOIN user
                               ON user.id = day_stat.user_id
                               WHERE user.login = '$this->login' && user.hash = '$this->hash' && day_stat.time >= CURDATE()")
            ->fetchAll(\PDO::FETCH_ASSOC);
        echo $this->twig->render('page/dash_board', array('param' => $this->options->param, 'table' => $data));
    }
    public function buy_userAction()
    {
        if(empty($_POST)) {
//  Вся мощность сети
            $network_power = $this->connection
                ->query("SELECT power FROM system_hashrate")
                ->fetchAll(\PDO::FETCH_ASSOC);
//            return $network_power = $network_power[0]['power'];

//  Вся мощность пользователя( активированная + не активируванная )
            $user_hash_sum_all = $this->connection
                ->query("SELECT SUM(power) AS power
                                   FROM contract
                                   WHERE user_id = '$this->user_id'")
                ->fetchAll(\PDO::FETCH_ASSOC);

//            return $user_hash_sum_all[0]['power'];

//  Возвращает все неактивированные контракты
            $orders_on_wait = $this->connection
                ->query("SELECT *, (contract.stamp_date - CURDATE()) AS dl
                                   FROM contract
                                   WHERE user_id = '$this->user_id' AND status = 0")
                ->fetchAll(\PDO::FETCH_ASSOC);
//            return $user_hash_sum_off[0];

//  Возвращает масив с двумя значениями off -  СУММА не активированная мощность, onn - активированная мощность
            $hash_on_off = $this->connection
                ->query("SELECT SUM(contract.power) AS off, (SELECT SUM(contract.power) 
                                                                       FROM contract 
                                                                       WHERE contract.status = 1) AS onn
                                   FROM  contract 
                                   WHERE  contract.status = 0")
                ->fetchAll(\PDO::FETCH_ASSOC);
            if($hash_on_off[0]['onn'] == null){
                $hash_on_off[0]['onn'] =0;
            }
//            return array('on' => $orders_on_wait_all_user[0]['onn'], 'off' => $orders_on_wait_all_user[0]['off']);

            $free_hash_rate = $network_power[0]['power'] - ($hash_on_off[0]['onn'] + $hash_on_off[0]['off']);

            echo $this->twig->render('page/buy_hash', array('param' => $this->options->param,
                                                                     'price' => $this->config->get('price'),
                                                                     'user_hash_rate' => $hash_on_off[0]['onn'],
                                                                     'network_hash_rate' => $network_power,
                                                                     'free_hash_rate' => $free_hash_rate,
                                                                     'orders_on_wait' => $orders_on_wait
                                                                     ));
        }else{
            $power = $_POST['data'][0]['value'];
            $price = $_POST['data'][1]['value'];
            DB::connection()
                ->query("INSERT INTO contract (user_id, power, stamp_date, price)
                                     VALUE ('$this->user_id', '$power', CURRENT_DATE + 3, '$price')");
////                ->execute(array('login' => $this->login, 'hash' => $this->hash, 'power' => $new_contract['power'], 'price' => $new_contract['price']));
        }
    }
    public function depositAction()
    {
        $data = $this->connection
            ->query("SELECT * FROM deposit WHERE user_id = '$this->user_id'")
            ->fetchAll(\PDO::FETCH_ASSOC);
        echo $this->twig->render('page/deposit', array('param' =>$this->options->param, 'data' => $data));
    }
    public function settingsAction()
    {
        $data = $this->connection
            ->query("SELECT * 
                              FROM user as u
                              LEFT JOIN account as a
                              ON u.id  = a.user_id
                              WHERE u.login = '$this->login' AND u.hash = '$this->hash'")
            ->fetchAll(\PDO::FETCH_ASSOC);
        var_dump($this->login);
        var_dump($this->hash);
        var_dump($data[0]);
        echo $this->twig->render('page/settings', array('param' => $this->options->param, 'data' => $data[0]));
    }
    public function outAction()
    {
         if(isset($_POST)) session_unset();
    }
}