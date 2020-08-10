<?php

namespace App\Controller;

use App\Service\TestService;
use App\Factory\Provider;

class TestController
{
    private $testService;

    public function __construct(TestService $testService, int $i)
    {
        echo $i;
        $this->testService = $testService;
    }

    public function test($id)
    {
        echo $id;
    }
}