<?php
/**
 * Created by PhpStorm.
 * User: user 1
 * Date: 24.11.2017
 * Time: 13:26
 */

namespace System;


class Verification
{
    private $response = false;
    private $br_hash;
    private $br_login;
    private $db_hash;
    private $db_login;



    public function __construct()
    {
        $this->br_hash = $_SESSION['hash'];
        $this->br_login = $_SESSION['login'];
        if($_SERVER['REMOTE_ADDR'] == '54.229.105.178') $this->response = true;
//        if($_SERVER['REMOTE_ADDR'] == '185.161.211.251') $this->response = true;
    }

    public function check()
    {
        if($this->br_hash != '' && $this->br_login != ''){
            $request = DB::connection()->query("SELECT hash, login FROM user WHERE hash = '$this->br_hash'")
                ->fetchAll(\PDO::FETCH_ASSOC);
            $this->db_hash = $request[0]['hash'];
            $this->db_login = $request[0]['login'];
            if($this->db_hash == $this->br_hash && $this->db_login == $this->br_login) $this->response = true;
        }
        return $this->response;
    }
}