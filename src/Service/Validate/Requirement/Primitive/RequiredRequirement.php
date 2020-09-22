<?php

namespace App\Service\Validate\Requirement\Primitive;

use App\Service\Validate\Requirement\RequirementInterface;

class RequiredRequirement implements RequirementInterface
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function check(): bool
    {
        return !empty($this->value);
    }
}