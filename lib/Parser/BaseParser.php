<?php
/**
 * Created by PhpStorm.
 * User: user 1
 * Date: 20.11.2017
 * Time: 7:39
 */

namespace Lib\Parser;

use App\Configuration\Conf;

include __DIR__.'/../../phpQuery-onefile.php';
abstract class BaseParser
{
    protected static function curl($url = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 YaBrowser/17.3.1.840 Yowser/2.5 Safari/537.36');
        curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $str = curl_exec($curl);
        curl_close($curl);
        return $str;
    }



}



