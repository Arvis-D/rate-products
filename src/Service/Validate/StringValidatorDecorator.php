<?php

namespace App\Service\Validate;

use App\Service\Validate\Requirement\EmailRequirement;
use App\Service\Validate\Requirement\StringLengthRequirement;

class StringValidatorDecorator extends PrimitiveValidator
{
    public function __construct(Validator $validator, bool $required)
    {
        parent::__construct($validator, $required);
    }

    public function length(int $min, int $max = PHP_INT_MAX)
    {
        $this->validator->validate(new StringLengthRequirement($this->getCurrentValue(), $min, $max), 'length');

        return $this;
    }

    /**
     * checks wether the string contains '@' symbol
     * and if there is at least one character before and after it
     * */

    public function email()
    {
        $this->validator->validate(new EmailRequirement($this->getCurrentValue(), 'email'));

        return $this;
    }
}
