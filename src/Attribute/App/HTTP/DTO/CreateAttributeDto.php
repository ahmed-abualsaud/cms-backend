<?php

namespace CMS\Attribute\App\HTTP\DTO;

use romanzipp\LaravelDTO\AbstractModelData;
use romanzipp\LaravelDTO\Attributes\ValidationRule;


class CreateAttributeDto extends AbstractModelData
{
    #[ValidationRule(['required', 'unique:attributes', 'string', 'min:1', 'max:255'])]
    public string $name;

    #[ValidationRule(['required', 'in:string,boolean,integer,float,double,date', 'string', 'min:1', 'max:255'])]
    public string $type;

    #[ValidationRule(['boolean'])]
    public bool $nullable;

    #[ValidationRule(['boolean'])]
    public bool $unique;
}
