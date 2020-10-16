<?php

namespace App\Service\Validate;

use App\Service\Validate\Requirement\RequirementInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Service\Validate\ValidationResourceInterface;

class Validator
{
    public $validationResource = null;
    public $errors = [];
    public $keyFailed = false;
    public $currentKey = '';
    public $values = [];
    public $session = null;
    private $translation = [];

    public function __construct(
        Session $session = null,
        ValidationResourceInterface $resource = null,
        array $translation = []
    ) {
        $this->session = $session;
        $this->translation = $translation;
        $this->validationResource = $resource;
    }

    /**
     * used when access to a resource is needed, for rexample, to check for uniqueness
     */

    public function setValidationResource(ValidationResourceInterface $resource): self
    {
        $this->validationResource = $resource;
        
        return $this;
    }

    /**
     * used to set errors in session that will be shown only once, then removed
     */

    public function setSession(Session $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function string(bool $required, string $key, string $value = null): StringValidatorDecorator
    {
        $this->value($key, $value);

        return new StringValidatorDecorator($this, $required);
    }

    public function number(bool $required, string $key, string $value = null): NumberValidatorDecorator
    {
        $this->value($key, $value);

        return new NumberValidatorDecorator($this, $required);
    }

    public function file(bool $required, string $key, string $value = null): FileValidatorDecorator
    {
        $this->value($key, $value);

        return new FileValidatorDecorator($this, $required);
    }

    private function value(string $key, $value = null)
    {
        if ($value !== null) {
            $this->values[$key] = $value;
        }

        $this->currentKey = $key;
        $this->keyFailed = false;
    }

    public function setParams(array $keyValuePairs): self
    {

        $this->values = $keyValuePairs;

        return $this;
    }

    public function getErrors()
    {
        $this->tryTranslate();
        $this->trySetFlashbagErrors();

        return $this->errors;
    }

    private function trySetFlashbagErrors()
    {
        if ($this->session !== null) {
            $this->setFlashbagErrors($this->errors);
        }
    }

    public function setFlashbagErrors(array $errors)
    {
        $this->session->getFlashBag()->set(
            'errors', 
            array_merge($errors, $this->session->getFlashBag()->get('errors'))
        );
    }

    public function setError(string $msg, string $key = null)
    {
        if ($key === null) {
            $this->errors[$this->currentKey] = $msg;
        } else {
            $this->errors[$key] = $msg;
        }

        $this->keyFailed = true;
    }

    /**
     * keyName.errorType => message
     * 
     * @example: ['age.number' => 'Age must be a number!", 'age.size' => 'Age must be at least 18!' ...]
     * 
     * errorType names will be the same as method names used to validate the values
     */

    public function setTranslation(array $translation): self
    {
        $this->translation = $translation;

        return $this;
    }

    private function tryTranslate()
    {
        if (!empty($this->translation)) {
            foreach ($this->translation as $key => $value) {
                if (count($keyVal = explode('.', $key)) !== 2) {
                    throw new \Exception('Invalid translation!');
                }

                [$keyName, $errorType] = $keyVal;

                if (
                    array_key_exists($keyName, $this->errors) &&
                    $this->errors[$keyName] === $errorType
                ) {
                    $this->errors[$keyName] = $value;
                }
            }
        }
    }

    public function isValid(): bool
    {
        return empty($this->getErrors());
    }

    public function validate(RequirementInterface $requirement, string $error = null)
    {
        if (!$this->keyFailed) {
            $this->keyFailed = !$requirement->check();

            if ($this->keyFailed && $error !== null) {
                $this->setError($error);
            }
        }
    }
}
