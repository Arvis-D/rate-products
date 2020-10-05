<?php

namespace App\Controller;

use App\Service\Validate\ValidationResourceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiValidationController
{
    private $resource;
    private $allowedResources = [
        'user' => ['email', 'name'],
        'product' => ['name']
    ];

    public function __construct(ValidationResourceInterface $resource)
    {
        $this->resource = $resource;
    }

    public function unique($resource, $field, $value)
    {
        if (array_key_exists($resource, $this->allowedResources)
            && in_array($field, $this->allowedResources[$resource])
        ) {
            return new JsonResponse([
                'unique' => $this->resource->checkUnique("{$resource}.{$field}", $value)
            ]);
        }

        return new JsonResponse([], 403);
    }

    /**
     * returns translated error messages
     */

    public function getErrors() 
    {
        
    }
}
