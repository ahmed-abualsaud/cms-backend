<?php

namespace CMS\Auth\Contract;

use CMS\Auth\Domain\Entity\User;

interface AuthServiceContract
{
    public function signin(array $signinDto);

    public function signup(array $signupDto);

    public function getOne(User $user);

    public function getAll();

    public function update(User $user, array $updateUserDto);

    public function delete(User $user);
}