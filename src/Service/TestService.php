<?php

namespace App\Service;

class TestService
{
    private $sserv;

    public function __construct(AnotherService $serv)
    {
        $this->sserv = $serv;
    }

    public function test()
    {
        $this->sserv->test();
        echo 'testing';
    }
}