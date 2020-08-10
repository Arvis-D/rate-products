<?php

namespace App\Utility;

class Csrf
{
    public static function randomStr()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ{})(*&^%$#@:|?!';
        $charlen = strlen($characters);
        $length = rand(100, 200);
        $randStr = '';
        for ($i = 0; $i < $length; $i++) {
            $randStr .= $characters[rand(0, $charlen - 1)];
        }

        return $randStr;
    }

    public static function match()
    {
        if (isset($_POST['csrf'])) {
            return ($_POST['csrf'] === $_SESSION['csrf'] ? true : false);
        }

        return false;
    }

    public static function setIfEmpty()
    {
        $_SESSION['csrf'] = (empty($_SESSION['csrf']) ? self::randomStr() : $_SESSION['csrf']);
    }
}