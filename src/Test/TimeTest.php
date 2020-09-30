<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use App\Helper\MySql\SimpleQuery;
use App\Helper\Time;

class TimeTest extends TestCase
{
    public function testElapsed()
    {
        $this->assertSame('0s', Time::getElapsedTime(time() + 123213));
        $this->assertSame('1min', Time::getElapsedTime(time() - 60));
        $this->assertSame('2min', Time::getElapsedTime(time() - 120));
        $this->assertSame('1h', Time::getElapsedTime(time() - 60 * 60));
    }
}
