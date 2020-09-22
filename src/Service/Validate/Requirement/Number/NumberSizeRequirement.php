<?php

namespace App\Service\Validate\Requirement\Number;

use App\Service\Validate\Requirement\RequirementInterface;

class NumberSizeRequirement implements RequirementInterface
{
    private $max;
    private $min;
    private $value;

    public function __construct($value, float $min = null, float $max = null)
    {
        $this->value = $value;
        $this->min = $min;
        $this->max = $max;
    }

    public function check(): bool
    {   
        $min = ($this->min === null ? true : $this->value > $this->min);
        $max = ($this->max === null ? true : $this->value < $this->max);

        return ($min && $max);
    }
}