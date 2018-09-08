<?php
/**
 * Created by PhpStorm.
 * User: user 1
 * Date: 27.12.2017
 * Time: 17:42
 */

namespace Lib\Parser;


use System\DB;

class ParseCoinCurs
{

    public function pars_courses()
    {
        $c = DB::connection();
        $x = $c->query("SELECT title FROM coin_cours")->fetchAll(\PDO::FETCH_ASSOC);
        $string = '';
        foreach ($x as $item){
            foreach ($item as $v){
                $string .= $v.',';
            }
        }
        $string =  trim($string, ',');
        $api_string = 'https://min-api.cryptocompare.com/data/pricemulti?fsyms='.$string.'&tsyms=USD';

        $coins = file_get_contents($api_string);
        $coins = json_decode($coins);

        foreach ($coins as $k => $v){
            $q = "UPDATE coin_cours SET amount = :amount WHERE title = :title";
            $p = array('amount' => $v->USD, 'title' => $k);
            $r = $c->prepare($q)->execute($p);
        }
    }
}