<?php

namespace CMS\Entity\App\HTTP\DTO;

use App\Rules\Unifne;
use romanzipp\LaravelDTO\AbstractModelData;
use romanzipp\LaravelDTO\Attributes\ValidationRule;


class UpdateEntityDto extends AbstractModelData
{
    #[ValidationRule([new Unifne('entities', 'entity'), 'string', 'min:1', 'max:255'])]
    public string $name;
}
