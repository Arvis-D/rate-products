<?php

namespace App\Service\Validate;

use App\Service\Validate\Requirement\File\FileRequiredRequirement;
use App\Service\Validate\Requirement\File\FileSizeRequirement;
use App\Service\Validate\Requirement\File\FileTypeRequirement;
use App\Service\Validate\Requirement\Number\NumberSizeRequirement;

class FileValidatorDecorator
{
    private $validator;

    public function __construct(Validator $validator, bool $required)
    {
        $this->validator = $validator;

        if ($required) {
            $this->required();
        } else {
            $this->optional();
        }
    }

    public function maxSize(float $sizeKb): self
    {
        $this->validator->validate(new FileSizeRequirement($this->validator->currentKey, $sizeKb));

        return $this;
    }

    public function type(array $types)
    {
        $this->validator->validate(new FileTypeRequirement($this->validator->currentKey, $types), 'type');
    }

    private function required()
    {
        $this->validator->validate(new FileRequiredRequirement($this->validator->currentKey), 'required');
    }

    private function optional()
    {
        $this->validator->validate(new FileRequiredRequirement($this->validator->currentKey));
    }
}
