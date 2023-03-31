<?php

namespace CMS\Auth\Domain\Service;

use CMS\Auth\Domain\Entity\User;
use CMS\Auth\Contract\AuthServiceContract;
use CMS\Auth\Domain\Repository\AuthRepository;

class AuthService implements AuthServiceContract
{
    public function __construct(
        private AuthRepository $authRepository
    ) {}

    public function signin(array $signinDto)
    {
        if (! $token = auth()->attempt($signinDto)) {
            return buildException(401, "Invalid User Credentials");
        }

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    public function signup(array $signupDto)
    {
        return $this->authRepository->create($signupDto);
    }

    public function getOne(User $user)
    {
        return $user;
    }

    public function getAll()
    {
        return $this->authRepository->getAll();
    }

    public function update(User $user, array $updateUserDto)
    {
        return $this->authRepository->update($user->id, $updateUserDto);
    }

    public function delete(User $user)
    {
        return $this->authRepository->delete($user->id);
    }
}