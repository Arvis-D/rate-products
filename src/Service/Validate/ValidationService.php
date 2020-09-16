<?php

namespace App\Service\Validate;

use App\Models\Database;
use App\Service\Validate\ValidationResourceInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class ValidationService
{
    private $resource;
    private $errors = [];
    private $firstError = false;
    private $values = [];
    private $keyUnderValidation;
    private $session = null;

    public function __construct(array $values = [])
    {
        $this->values = $values;        
    }

    public function setSession(Session $session) 
    {
        $this->session = $session;
    }

    public function setSessionErrors(array $errors)
    {
        if ($this->session === null) {
            throw new \Exception('session not set!');
        }

        $this->session->getFlashBag()->set('errors', $errors);
    }

    /**
     * Checks wether errors are empty and sets them in the session flashbag if they are not
     * 
     * @return bool true if empty
     */

    public function noErrors(array $errors): bool
    {
        if (empty($errors)) {
            return true;
        } else {
            $this->setSessionErrors($errors);
            return false;
        }
    }

    public function setValues(array $values)
    {
        $this->values = $values;
        return $this;
    }

    public function setResource(ValidationResourceInterface $resource)
    {
        $this->resource = $resource;
        return $this;
    }

    private function setError($msg)
    {
        $this->errors[$this->keyUnderValidation] = $msg;
        $this->firstError = true;
    }

    public function key(string $key)
    {
        $this->keyUnderValidation = $key;
        $this->firstError = false;
        return $this;
    }

    public function value(string $key, string $value)
    {
        $this->values = array_merge($this->values, [$key => $value]);
        $this->keyUnderValidation = $key;
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

        $len = strlen((string) $this->values[$this->keyUnderValidation]);
        if ($len < $minLen || $len > $maxLen) {
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

        if (!$this->resource->checkUnique($uniqueWhere, $this->values[$this->keyUnderValidation])) {
            $this->setError('unique');
        }

        return $this;
    }

    public function required()
    {
        if ($this->firstError) return $this;

        if (empty($this->values[$this->keyUnderValidation])) {
            $this->setError('required');
        }

        return $this;
    }

    public function numeric(float $min = null, float $max = null)
    {
        if ($this->firstError) return $this;
        $value = $this->values[$this->keyUnderValidation];

        if (!is_numeric($value)) {
            $this->setError('numeric');
        } else {
            if ($min !== null) {
                if ($value < $min) {
                    $this->setError('numericSize');
                }
            }
            if ($max !== null) {
                if ($value > $max) {
                    $this->setError('numericSize');
                }
            }
        }

        return $this;
    }

    public function email()
    {
        if ($this->firstError) return $this;
        $value = $this->values[$this->keyUnderValidation];
        $pos = strpos($value, '@');

        if ($pos < 1 || $pos > strlen($value) - 2) {
            $this->setError('email');
        }

        return $this;
    }

    public function optional()
    {
        if ($this->firstError) return $this;
        $value = $this->values[$this->keyUnderValidation];

        if (empty($value)) {
            $this->firstError = true;
        }

        return $this;
    }

    /**
     * @param $translation example:
     *  ['password.length' => 'password has to be between 8 and 24 characters long']
     */

    public function translateErrors(array $translation)
    {
        foreach ($translation as $key => $value) {
            [$name, $validationRequirement] = explode('.', $key);
            if (array_key_exists($name, $this->errors) && $this->errors[$name] === $validationRequirement) {
                $this->errors[$name] = $value;
            }
        };

        return $this;
    }
}