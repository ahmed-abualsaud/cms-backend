<?php

namespace CMS\Attribute\Domain\Entity;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $guarded = [];

    protected $casts = [
        'nullable' => 'boolean',
        'unique' => 'boolean'
    ];
}