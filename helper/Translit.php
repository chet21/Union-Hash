<?php
/**
 * Created by PhpStorm.
 * User: user 1
 * Date: 03.12.2017
 * Time: 10:32
 */

namespace Helper;


class Translit
{
    private function translit($str)
    {
        $str = mb_strtolower($str, 'utf-8');
        $list = array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ж' => 'j',
            'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm',
            'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ч' => 'ch', 'ц' => 'ts', 'ш' => 'sh',
            'щ' => 'shch', 'ы' => 'u', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', ' ' => '-',
            'ъ'=> '', 'ь'=> '');

        return strtr($str, $list);

    }
}