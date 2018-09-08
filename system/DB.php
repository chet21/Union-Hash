<?php

namespace System;

use App\Configuration\Conf;

class DB extends Conf
{
    private static $connection;

    private function __construct()
    {
    }

    static function connection()
    {
        if (self::$connection == null) {
            try
            {
                $r = self::init()->get('host');
                self::$connection = new \PDO('mysql:host=localhost;dbname=ubi', 'chet21', 'greg21');
            }
            catch(\PDOException $e)
            {
                echo "Ошибка: ".$e->getMessage()."<br>";
                echo "Место ошибки: ".$e->getLine();
            }
        }
        return self::$connection;
    }
}
