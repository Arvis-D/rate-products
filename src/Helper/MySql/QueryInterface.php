<?php

namespace App\Helper\MySql;

interface QueryInterface
{
    public function getParams(): array;

    public function getQuery(): string;
}
