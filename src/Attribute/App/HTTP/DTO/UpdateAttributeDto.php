<?php

namespace CMS\Attribute\App\HTTP\DTO;

use App\Rules\Unifne;
use romanzipp\LaravelDTO\AbstractModelData;
use romanzipp\LaravelDTO\Attributes\ValidationRule;


class UpdateAttributeDto extends AbstractModelData
{
    #[ValidationRule([new Unifne('attributes', 'attribute'), 'string', 'min:1', 'max:255'])]
    public string $name;

    #[ValidationRule(['string', 'in:string,bool,boolean,int,integer,float,double,date', 'min:1', 'max:255'])]
    public string $type;

    #[ValidationRule(['boolean'])]
    public bool $nullable;

    #[ValidationRule(['boolean'])]
    public bool $unique;
}