<?php

namespace App\Service\Validate\Requirement\String;

use App\Service\Validate\Requirement\RequirementInterface;

class EmailRequirement implements RequirementInterface
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function check(): bool
    {
        $pos = strpos($this->value, '@');
        $count = strlen($this->value);

        return !($pos < 1 || $pos > $count - 2);
    }
}