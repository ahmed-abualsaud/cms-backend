<?php

namespace CMS\Auth\App\HTTP\DTO;

use App\Rules\Unifne;
use romanzipp\LaravelDTO\AbstractModelData;
use romanzipp\LaravelDTO\Attributes\ValidationRule;


class UpdateUserDto extends AbstractModelData
{
    #[ValidationRule([new Unifne('users', 'user'), 'string', 'min:1', 'max:255'])]
    public string $name;

    #[ValidationRule([new Unifne('users', 'user'), 'string', 'min:1', 'max:255'])]
    public string $email;

    #[ValidationRule(['string', 'min:1', 'max:255'])]
    public string $password;

    #[ValidationRule(['in:admin,operator', 'string', 'min:1', 'max:255'])]
    public string $role;
}
