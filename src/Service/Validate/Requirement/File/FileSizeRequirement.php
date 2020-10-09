<?php

namespace App\Service\Validate\Requirement\File;

use App\Service\Validate\Requirement\RequirementInterface;

class FileSizeRequirement implements RequirementInterface
{
    private $key;
    private $maxBytes;

    public function __construct(string $key, int $maxSizeKb)
    {
        $this->maxBytes = $maxSizeKb * 1024;
        $this->key = $key;
    }

    public function check(): bool
    {
        return $_FILES[$this->key]['size'] < $this->maxBytes;
    }
}
