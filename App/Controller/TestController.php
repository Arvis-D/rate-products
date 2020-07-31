<?php

namespace App\Controller;

use App\Service\TestService;

class TestController
{
    private $testService;

    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    public function test()
    {
        return $this->testService->test();
    }
}