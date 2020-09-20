<?php

namespace App\Service\Validate;

use App\Service\Validate\Requirement\NumberRequirement;
use App\Service\Validate\Requirement\NumberSizeRequirement;

class NumberValidatorDecorator extends PrimitiveValidator
{
    public function __construct(Validator $validator, bool $required)
    {
        parent::__construct($validator, $required);
        $this->checkIfnumber();
    }

    public function min(float $min): self
    {
        $this->validator->validate(new NumberSizeRequirement($this->getCurrentValue(), $min), 'min');

        return $this;
    }

    public function max(float $max): self
    {
        $this->validator->validate(new NumberSizeRequirement($this->getCurrentValue(), null, $max), 'max');

        return $this;
    }


    private function checkIfnumber()
    {
        $this->validator->validate(new NumberRequirement($this->getCurrentValue()), 'number');
    }
}
