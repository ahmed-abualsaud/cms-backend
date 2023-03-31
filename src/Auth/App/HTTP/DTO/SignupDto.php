<?php

namespace CMS\Auth\App\HTTP\DTO;

use romanzipp\LaravelDTO\AbstractModelData;
use romanzipp\LaravelDTO\Attributes\ValidationRule;


class SignupDto extends AbstractModelData
{
    #[ValidationRule(['required', 'unique:users', 'string', 'min:1', 'max:255'])]
    public string $name;

    #[ValidationRule(['required', 'unique:users', 'string', 'min:1', 'max:255'])]
    public string $email;

    #[ValidationRule(['required', 'string', 'min:1', 'max:255'])]
    public string $password;

    #[ValidationRule(['required', 'in:admin,operator', 'string', 'min:1', 'max:255'])]
    public string $role;
}