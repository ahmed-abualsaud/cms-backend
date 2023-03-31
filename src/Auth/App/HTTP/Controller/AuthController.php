<?php

namespace CMS\Auth\App\HTTP\Controller;

use CMS\Auth\Domain\Entity\User;
use CMS\Auth\App\HTTP\DTO\SigninDto;
use CMS\Auth\App\HTTP\DTO\SignupDto;
use CMS\Auth\App\HTTP\DTO\UpdateUserDto;
use CMS\Auth\Contract\AuthServiceContract;

use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Put;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Prefix;


#[Prefix('api/users')]
class AuthController 
{
    public function __construct(
        private AuthServiceContract $authService
    ) {}

    #[Post('/signin')]
    public function signin(SigninDto $signinDto)
    {
        $signinDto = $signinDto->toArray();
        $signinDto['name'] = $signinDto['username'];
        unset($signinDto['username']);

        return jsonResponse($this->authService->signin($signinDto));
    }

    #[Post('/signup', middleware: ['auth:api', 'role:admin'])]
    public function signup(SignupDto $signupDto)
    {
        $signupDto = $signupDto->toArray();
        $signupDto['password'] = bcrypt($signupDto['password']);
        return jsonResponse($this->authService->signup($signupDto));
    }

    #[Get('/{user}', middleware: ['auth:api', 'role:admin'])]
    public function getOne(User $user)
    {
        return jsonResponse($this->authService->getOne($user));
    }

    #[Get('/', middleware: ['auth:api', 'role:admin'])]
    public function getAll()
    {
        return jsonResponse($this->authService->getAll());
    }

    #[Put('/{user}', middleware: ['auth:api', 'role:admin'])]
    public function update(User $user, UpdateUserDto $updateUserDto)
    {
        $updateUserDto = $updateUserDto->toArray();
        if (array_key_exists('password', $updateUserDto)) {
            $updateUserDto['password'] = bcrypt($updateUserDto['password']);
        }

        return jsonResponse($this->authService->update($user, $updateUserDto));
    }

    #[Delete('/{user}', middleware: ['auth:api', 'role:admin'])]
    public function delete(User $user)
    {
        return jsonResponse($this->authService->delete($user));
    }    
}