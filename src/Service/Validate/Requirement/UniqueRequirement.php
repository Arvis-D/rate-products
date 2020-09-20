<?php

namespace App\Service\Validate\Requirement;

use App\Service\Validate\ValidationResourceInterface;

class UniqueRequirement implements RequirementInterface
{
    private $value;
    private $res;
    private $where;

    public function __construct($value, ValidationResourceInterface $res, string $uniqueWhere)
    {
        $this->res = $res;
        $this->value = $value;
        $this->where = $uniqueWhere;
    }

    public function check(): bool
    {
        return $this->res->checkUnique($this->where, $this->value);
    }
}