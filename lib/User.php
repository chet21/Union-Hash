<?php

namespace lib;


use Helper\Hash;
use System\DB;

class User
{
    private $connection;

    public function __construct()
    {
        $this->connection = DB::connection();
    }

    public function authorization($login, $password, $sold)
    {
        $login  = htmlspecialchars($login);
        $password = md5(htmlspecialchars($password).$sold);
        $hash = Hash::get();

        $data = $this->connection
//            ->prepare("SELECT * FROM user WHERE login = '?' AND password = '?'")
//            ->execute(array($this->login, $this->password));
            ->query("SELECT * FROM user WHERE login = '$login' AND password = '$password'")
            ->fetchAll(\PDO::FETCH_ASSOC);
        $res = ($data) ? 1 : 0;
        if($res == 1) {
            $_SESSION['login'] = $login;
            $_SESSION['hash'] = $hash;
            $this->connection
                ->prepare("UPDATE user SET hash = :hash WHERE login = :login")
                ->execute(array('hash' => $hash, 'login' => $login));
        }
        return $res;

    }

    public function registration($login, $password, $sold)
    {
        $login  = htmlspecialchars($login);
        $password = md5(htmlspecialchars($password).$sold);

        $this->connection->beginTransaction();
        $this->connection
            ->query("INSERT INTO user (login, password) VALUE ('$login', '$password')");
        $id = $this->connection->lastInsertId();
        $this->connection
            ->query("INSERT INTO account (user_id) VALUE ($id)");
        $this->connection->commit();

    }

    public function check($login)
    {
        $login  = htmlspecialchars($login);
        $res = 0;

        $data = DB::connection()
            ->query("SELECT * FROM user WHERE login = '$login'")
            ->fetchAll(\PDO::FETCH_ASSOC);

       if($data) $res =1;
       return $res;
    }
}