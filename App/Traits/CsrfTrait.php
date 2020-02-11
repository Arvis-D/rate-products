<?php

namespace App\Traits;

trait CsrfTrait
{
    private function randomStr()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ{})(*&^%$#@:|<>?!';
        $charlen = strlen($characters);
        $length = rand(100, 200);
        $randStr = '';
        for($i = 0; $i < $length; $i++){
            $randStr .= $characters[rand(0, $charlen - 1)];
        }

        return $randStr;
    }

    private function csrfMatch()
    {
        if(isset($_POST['csrf'])){
            return ($_POST['csrf'] === $_SESSION['csrf'] ? true : false);
        } else {
            return false;
        }
    }
}