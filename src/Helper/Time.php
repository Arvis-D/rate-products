<?php

namespace App\Helper;

class Time
{
    /**
     * @param $elapsedTime in seconds
     * 
     * @return $elapsedTime in days weeks, etc
     * @example 60 second input will return "1min"
     */

    public static function getElapsedTime(?int $timeCreated): ?string
    {
        if ($timeCreated === null) {
            return null;
        }

        $elapsed = time() - $timeCreated;
        $minute = 60;
        $hour = $minute * 60;
        $day = $hour * 24;
        $week = $day * 7;
        $year = ($day * 365) + ($day * 0.24);
        $month = $year / 12;

        $times = [1, $minute, $hour, $day, $week, $month, PHP_INT_MAX];
        $postfix = ['s', 'min', 'h', 'd', 'w', 'm'];

        $count = 0;
        while (1 < $elapsed / $times[$count]) {
            $count++;
        }
        $count -= 1;

        return floor($elapsed / $times[$count]) . $postfix[$count];
    }
}
