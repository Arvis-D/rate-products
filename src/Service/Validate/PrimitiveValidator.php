<?php

namespace App\Service\Validate;

use App\Service\Validate\Requirement\Primitive\ExistsRequirement;
use App\Service\Validate\Requirement\Primitive\RequiredRequirement;
use App\Service\Validate\Requirement\Primitive\UniqueRequirement;

abstract class PrimitiveValidator
{
    public $validator;

    public function __construct(Validator $validator, bool $required)
    {
        $this->validator = $validator;

        if ($required) {
            $this->required();
        } else {
            $this->optional();
        }
    }

    /**
     * @param $uniqueWhere where it will check uniqueness
     * @example 'product.name'
     * 
     * @return static 
     */

    public function unique(string $uniqueWhere): self
    {
        if (null === $resource = $this->validator->validationResource) {
            throw new \Exception('Validator: Cannot check uniqueness, resource not set!');
        }

        $this->validator->validate(new UniqueRequirement($this->getCurrentValue(), $resource, $uniqueWhere), 'unique');

        return $this;
    }

    public function exists(string $uniqueWhere): self
    {
        if (null === $resource = $this->validator->validationResource) {
            throw new \Exception('Validator: Cannot check existance, resource not set!');
        }

        $this->validator->validate(new ExistsRequirement($this->getCurrentValue(), $resource, $uniqueWhere), 'exists');

        return $this;
    }

    /**
     * @return static
     */

    private function required(): self
    {
        $this->validator->validate(new RequiredRequirement($this->getCurrentValue()), 'required');

        return $this;
    }

    /**
     * will check if value is empty but wont set any errors,
     * any further validation for the value will be suspended if it is
     * 
     *
     * @return static
     */

    private function optional(): self
    {
        $this->validator->validate(new RequiredRequirement($this->getCurrentValue()));

        return $this;
    }

    public function getCurrentValue()
    {
        $validator = $this->validator;

        return (array_key_exists($validator->currentKey, $validator->values) ? $validator->values[$validator->currentKey] : null);
    }
}
