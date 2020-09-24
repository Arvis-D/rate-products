<?php

namespace App\Service\Validate;

use App\Service\Validate\Requirement\File\FileRequiredRequirement;
use App\Service\Validate\Requirement\File\FileTypeRequirement;
use App\Service\Validate\Requirement\Number\NumberSizeRequirement;

class FileValidatorDecorator
{
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function maxSize(float $sizeKb): self
    {
        $this->validator->validate(
            new NumberSizeRequirement($_FILES[$this->validator->currentKey]['size'], null, $sizeKb * 1024),
            'maxSize'
        );

        return $this;
    }

    public function type(array $types)
    {
        $this->validator->validate(New FileTypeRequirement($this->validator->currentKey, $types), 'type');
    }

    public function required()
    {
        $this->validator->validate(New FileRequiredRequirement($this->validator->currentKey), 'required');
    }

    public function optional()
    {
        $this->validator->validate(New FileRequiredRequirement($this->validator->currentKey));
    }
}
