<?php

namespace CMS\EAV\Domain\Entity;

use Illuminate\Database\Eloquent\Model;

class EAV extends Model
{
    protected $guarded = [];

    protected $table = 'eav';
}