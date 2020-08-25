<?php

namespace App\Test;

use App\Service\Validate\DbValidationResource;
use App\Service\Validate\ValidationResourceInterface;
use PHPUnit\Framework\TestCase;
use App\Service\Validate\ValidationService;

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

        $validate = new ValidationService($values);
        $resource = $this->createMock(ValidationResourceInterface::class);
        $resource
            ->method('checkUnique')
            ->willReturn(false);

        $errors = $validate
            ->key('email')->required()->email()
            ->key('username')->required()->setResource($resource)->unique('user.name')
            ->key('password')->required()->len(7)
            ->key('age')->required()->numeric()
            ->key('required')->required()
            ->getErrors();

        $this->assertSame([
            'username' => 'unique',
            'password' => 'length',
            'age' => 'numeric',
            'required' => 'required'
        ], $errors);
    }
}
