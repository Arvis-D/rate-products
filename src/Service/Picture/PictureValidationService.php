<?php

namespace App\Service\Picture;

use App\Service\Validate\BaseValidationService;
use App\Service\Validate\ValidationResourceInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class PictureValidationService extends BaseValidationService
{
    public function __construct(Session $session, ValidationResourceInterface $resource)
    {
        parent::__construct($resource, $session);

        $this->errorTranslations = array_merge(
            $this->errorTranslations, 
            ['image.required' => 'Image is required!']
        );
    }

    public function validatePicture(string $key)
    {
        $validator = $this->getValidator();
        $validator->file(true, 'image')->maxSize($this->maxImageSize)->type($this->allowedImageTypes);

        return $validator->isValid();
    }
}
