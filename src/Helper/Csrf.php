<?php

namespace App\Helper;

use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class Csrf
{
    private $csrfManager;
    private $id = 1;

    public function __construct(CsrfTokenManagerInterface $csrfManager)
    {
        $this->csrfManager = $csrfManager;
    }

    public function getTokenStr(): string
    {
        return $this->csrfManager->getToken(1)->getValue();
    }

    public function check(?string $token): bool
    {
        if ($token === null) {
            return false;
        }
        $token = new CsrfToken($this->id, $token);
        return $this->csrfManager->isTokenValid($token);
    }
}
