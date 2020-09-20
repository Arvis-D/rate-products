<?php

namespace App\Test;

use App\Service\Validate\DbValidationResource;
use App\Service\Validate\ValidationResourceInterface;
use PHPUnit\Framework\TestCase;
use App\Service\Validate\ValidationService;
use App\Service\Validate\ValidatorFactory;

class ValidationServiceTest extends TestCase
{
    public function testValidation()
    {
        $values = [
            'email' => 'advertir@gmail.com',
            'username' => 'mrRand',
            'password' => '123',
            'age' => 's12',
            'required' => ''
        ];

        $validator = ValidatorFactory::create()->setParams($values);
        $resource = $this->createMock(ValidationResourceInterface::class);
        $resource
            ->method('checkUnique')
            ->willReturn(false);

        $validator->setValidationResource($resource);
        $validator->string(true, 'email')->email();
        $validator->string(true, 'username')->unique('user.name');
        $validator->string(true, 'password')->length(7);
        $validator->number(true, 'age');
        $validator->string(true, 'required');
        $validator->string(true, 'nonExistent');
        $errors = $validator->getErrors();

        $this->assertSame([
            'username' => 'unique',
            'password' => 'length',
            'age' => 'number',
            'required' => 'required',
            'nonExistent' => 'required'
        ], $errors);
    }
}
