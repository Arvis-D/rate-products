<?php

namespace App\Service\Validate;

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
            new NumberSizeRequirement($_FILES[$this->validator->currentKey]['size'], null, $sizeKb),
            'maxSize'
        );

        return $this;
    }

    public function type()
    {

    }

    public function required()
    {

    }

    public function optional()
    {

    }
}
