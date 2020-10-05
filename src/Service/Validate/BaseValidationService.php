<?php

namespace App\Service\Validate;

use App\Service\Validate\ValidatorFactory;
use Symfony\Component\HttpFoundation\Session\Session;

class BaseValidationService
{
    protected $resource;
    protected $session;

    protected $allowedImageTypes = ['jpg', 'jpeg', 'png'];
    protected $maxImageSize = 1024;
    protected $ratingMin = 0;
    protected $ratingMax = 5;
    protected $commentLength = 500;

    protected $errorTranslations = [
        'price.number' => 'Price has to be a numeric!',
        'price.min' => 'Price has to be a positive number!',
        'name.required' => 'Product name is required!',
        'name.unique' => 'Such product already exists!',
        'rating.number' => 'Rating has to be a numeric!',
        'rating.min' => 'Rating has to be between 0 and 5!',
        'rating.max' => 'Rating has to be between 0 and 5!',
        'comment.length' => 'Comments may not be longer than 500 characters',
        'image.file' => 'Image must be a file!',
        'image.type' => 'Image type must one of the following: png, jpeg, jpg!',
        'image.size' => 'Image must not be larger than 1MB!'
    ];

    public function __construct(ValidationResourceInterface $resource, Session $session)
    {
        $this->session = $session;
        $this->resource = $resource;
    }

    protected function getValidator(): Validator
    {
        return ValidatorFactory::create()
            ->setSession($this->session)
            ->setValidationResource($this->resource)
            ->setTranslation($this->errorTranslations);
    }

    public function getErrors()
    {
        
    }
}
