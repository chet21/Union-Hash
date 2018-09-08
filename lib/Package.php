<?php

namespace Lib;

use System\DB;

class Package
{
    public $param;

    public function __construct()
    {
        $this->PackageOptions();
    }

    private function PackageOptions()
    {
//        $ln = $_COOKIE['lang'];

        $ln = 'ua';
        $login = $_SESSION['login'];
        $hash = $_SESSION['hash'];
        $menu = DB::connection()
            ->query("SELECT * FROM menu")
            ->fetchAll(\PDO::FETCH_ASSOC);
        $data = DB::connection()
            ->query("SELECT *, (SELECT SUM(power) FROM contract WHERE status = 1) AS su
                               FROM account
                               LEFT JOIN user
                               ON user.id = account.user_id
                               WHERE user.hash = '$hash'")
            ->fetchAll(\PDO::FETCH_ASSOC);
        if($data[0]['su'] == null){
            $data[0]['su'] = 0;
        }
        $courses = DB::connection()
            ->query("SELECT * FROM coin_cours")
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $this->param = array('ln' => $ln, 'menu' => $menu, 'login' => $login, 'data' => $data[0], 'test_number' => 1, 'courses' => $courses);
    }
}
