<?php

namespace App\Service\Validate\Requirement\File;

use App\Service\Validate\Requirement\RequirementInterface;

class FileTypeRequirement implements RequirementInterface
{
    private $key;
    private $allowedTypes;

    public function __construct(string $key, array $allowedTypes)
    {
        $this->allowedTypes = $allowedTypes;
        $this->key = $key;
    }

    public function check(): bool
    {
        $type = explode('/', $_FILES[$this->allowedTypes])[1];

        return in_array($type, $this->allowedTypes);
    }
}