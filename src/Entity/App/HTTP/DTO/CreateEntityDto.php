<?php

namespace CMS\Entity\App\HTTP\DTO;

use romanzipp\LaravelDTO\AbstractModelData;
use romanzipp\LaravelDTO\Attributes\ValidationRule;


class CreateEntityDto extends AbstractModelData
{
    #[ValidationRule(['required', 'unique:entities', 'string', 'min:1', 'max:255'])]
    public string $name;
}