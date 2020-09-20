<?php

namespace App\Service\Validate\Requirement;

class NumberRequirement implements RequirementInterface
{
    private $value;

    public function __construct($value)
    {
        $this->$value = $value;
    }

    public function check(): bool
    {
        return is_numeric($this->value);
    }
}