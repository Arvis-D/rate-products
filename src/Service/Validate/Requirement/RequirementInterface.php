<?php

namespace App\Service\Validate\Requirement;

interface RequirementInterface
{
    public function check(): bool;
}
