<?php

namespace CMS\EAV\App\HTTP\DTO;

use romanzipp\LaravelDTO\AbstractModelData;
use romanzipp\LaravelDTO\Attributes\ValidationRule;


class AssignAttributesDto extends AbstractModelData
{
    #[ValidationRule(['exists:entities,id', 'int'])]
    public int $entityID;

    #[ValidationRule(['required_without:entityID', 'exists:entities,name', 'string', 'min:1', 'max:255'])]
    public string $entityName;

    #[ValidationRule(['required', 'array'])]
    public array $attributes;
}
