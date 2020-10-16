<?php

namespace App\Service;

use App\Repository\UserRepositoryInterface;
use App\Service\Auth\AuthServiceInterface;
use App\Service\Auth\AuthValidationService;
use Symfony\Component\HttpFoundation\Request;

class UserService
{
    private $userRepo;
    public $auth;
    private $image;
    private $validation;

    public function __construct(
        UserRepositoryInterface $userRepo,
        AuthServiceInterface $auth,
        ImageService $image,
        AuthValidationService $validation
    ) {
        $this->validation = $validation;
        $this->userRepo = $userRepo;
        $this->auth = $auth;
        $this->image = $image;
    }

    public function login(string $username, string $password, bool $remember): bool
    {
        if (null === $user = $this->userRepo->getIdAndPassword($username)) {
            $this->setLoginError();

            return false;
        }

        if (password_verify($password, $user['password'])) {
            $this->auth->authenticate($username, $user['id'], $remember);

            return true;
        } else {
            $this->setLoginError();
        }

        return false;
    }

    public function signup(Request $request): bool
    {
        if (
            !$this->validation->validateSignup($request->request->all())
            || !$this->image->validation->validateImage(false)
        ) {
            return false;
        }

        $userId = $this->userRepo->addUser(
            $request->get('username'),
            $request->get('email'),
            password_hash($request->get('password'), PASSWORD_DEFAULT)
        );

        if (null !== $avatar = $request->files->get('image'))
        {
            $url = $this->image->createSetOfImages($avatar, 'user', $userId);
            $this->userRepo->setAvatar($userId, $url);
        }

        $this->auth->authenticate($request->get('username'), $userId, ($request->get('remember-me') !== null));

        return true;
    }

    private function setLoginError()
    {
        $this->validation->validator->setFlashbagErrors(['login' => 'Incorrect username or password!']);
    }

    private function setPasswordError()
    {
        $this->validation->validator->setFlashbagErrors(['password' => 'Incorrect password!']);
    }

    public function update(Request $request)
    {
        if (!$this->validation->validateUpdate($request->request->all(), $request->get('current-username'), $request->get('current-email'))) {

            return;
        }

        $password = $this->userRepo->getPassword($this->auth->authParams('id'));

        if (!password_verify($request->get('password'), $password)) {
            $this->setPasswordError();

            return;
        }

        $file = $request->files->get('image');
        $url = ($file === null ? null : $this->image->createSetOfImages($file, 'user', $this->auth->authParams('id')));

        $this->userRepo->update(
            $this->auth->authParams('id'),
            $request->get('username'),
            $request->get('email'),
            (empty($request->get('new-password')) ? null : password_hash($request->get('new-password'), PASSWORD_DEFAULT)),
            $url
        );
    }
}
