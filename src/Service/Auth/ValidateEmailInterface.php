<?php

namespace App\Service\Auth;

interface ValidateEmailInterface
{
    public function sendValidationEmail();

    public function validateRecievedKey();
}
