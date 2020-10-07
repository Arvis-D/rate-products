<?php

namespace App\Service\Product;

use App\Service\Validate\BaseValidationService;
use App\Service\Validate\ValidationResourceInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class ProductValidationService extends BaseValidationService
{
    public function __construct(ValidationResourceInterface $resource, Session $session)
    {  
        parent::__construct($resource, $session);
    }

    public function validateProductCreation(array $params): bool
    {
        $validator = $this->getValidator()->setParams($params);
        $validator->string(true, 'name')->unique('product.name');
        $validator->number(false, 'price')->min(0);
        $validator->number(false, 'rating')->min(0)->max(5);
        $validator->string(false, 'comment')->length(0, 500);
        $validator->file(false, 'image')->maxSize($this->maxImageSize)->type(['png', 'jpg', 'jpeg']);

        return $validator->isValid();
    }
}
