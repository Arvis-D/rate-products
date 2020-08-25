<?php

namespace App\Service\Validate;

use App\Models\Database;
use App\Service\Validate\ValidationResourceInterface;

class ValidationService
{
    private $resource;
    private $errors = [];
    private $firstError = false;
    private $values;
    private $underValidation;

    public function __construct(array $values = [])
    {
        $this->values = $values;        
    }

    public function setValues(array $values)
    {
        $this->values = $values;
    }

    public function setResource(ValidationResourceInterface $resource)
    {
        $this->resource = $resource;
        return $this;
    }

    private function setError($msg)
    {
        $this->errors[$this->underValidation] = $msg;
        $this->firstError = true;
    }

    public function key(string $key)
    {
        $this->underValidation = $key;
        $this->firstError = false;
        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function len(int $minLen, int $maxLen = PHP_INT_MAX)
    {
        if ($this->firstError) return $this;

        $len = strlen((string) $this->underValidation);
        if ($len > $minLen || $len < $maxLen) {
            $this->setError('length');
        }

        return $this;
    }

    public function unique($uniqueWhere)
    {
        if ($this->firstError) return $this;

        if ($this->resource === NULL) {
            throw new \Exception('Validator resource is null');
        }

        if (!$this->resource->checkUnique($uniqueWhere, $this->values[$this->underValidation])) {
            $this->setError('unique');
        }

        return $this;
    }

    public function required()
    {
        if ($this->firstError) return $this;

        if (empty($this->values[$this->underValidation])) {
            $this->setError('required');
        }

        return $this;
    }

    public function numeric()
    {
        if ($this->firstError) return $this;

        if (!is_numeric($this->values[$this->underValidation])) {
            $this->setError('numeric');
        }

        return $this;
    }

    public function email()
    {
        if ($this->firstError) return $this;
        $value = $this->values[$this->underValidation];
        $pos = strpos($value, '@');

        if ($pos < 1 || $pos > strlen($value) - 2) {
            $this->setError('email');
        }

        return $this;
    }
}