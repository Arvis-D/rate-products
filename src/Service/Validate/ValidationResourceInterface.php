<?php

namespace App\Service\Validate;

interface ValidationResourceInterface
{
    public function checkUnique(string $uniqueWhere, string $uniqueWhat): bool;
}
