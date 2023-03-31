<?php

namespace CMS\Auth\App\HTTP\DTO;

use romanzipp\LaravelDTO\AbstractModelData;
use romanzipp\LaravelDTO\Attributes\ValidationRule;


class SigninDto extends AbstractModelData
{
    #[ValidationRule(['required', 'exists:users,name', 'string', 'min:1', 'max:255'])]
    public string $username;

    #[ValidationRule(['required', 'string', 'min:1', 'max:255'])]
    public string $password;
}