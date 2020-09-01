<?php

namespace App\Service\Auth;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use PHPMailer\PHPMailer\PHPMailer;

// will implement later
class EmailValidationService implements ValidateEmailInterface
{
    private $mailer;

    public function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendValidationEmail()
    {
        $this->mailer->isSMTP();
        $this->mailer->SMTPAuth = true;
        $this->mailer->SMTPSecure = 'ssl';
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->Port = '465';
    }

    public function validateRecievedKey()
    {
        
    }
}
