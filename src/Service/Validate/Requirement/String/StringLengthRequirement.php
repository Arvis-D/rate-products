<?php

namespace App\Service\Validate\Requirement\String;

use App\Service\Validate\Requirement\RequirementInterface;

class StringLengthRequirement implements RequirementInterface
{
    private $max;
    private $min;
    private $value;

    public function __construct($value, int $min, int $max = 0)
    {
        $this->max = $max;
        $this->min = $min;
        $this->value = $value;
    }

    public function check(): bool
    {
        $len = strlen($this->value);

        return ($len >= $this->min && $len <= $this->max);
    }
}