<?php

namespace App\Service\Picture;

use App\Service\Validate\ValidatorFactory;

class PictureValidationService
{
    private $errorTranslations = [
        'image.file' => 'Image must be a file!',
        'image.type' => 'Image type must one of the following: png, jpeg, jpg!',
        'image.size' => 'Image must not be larger than 1MB!',
        'image.required' => 'Image is required!'
    ];
    private $allowedImageTypes = ['jpg', 'jpeg', 'png'];
    private $maxImageSize = 2048;
    private $validator;

    public function __construct(ValidatorFactory $validatorFactory)
    {
        $this->validator = $validatorFactory->create($this->errorTranslations);
    }

    public function validateImage(bool $required = true)
    {
        $this->validator->file($required, 'image')->maxSize($this->maxImageSize)->type($this->allowedImageTypes);

        return $this->validator->isValid();
    }
}
