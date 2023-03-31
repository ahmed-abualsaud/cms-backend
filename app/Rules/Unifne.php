<?php

namespace App\Rules;

use Illuminate\Validation\Rules\Unique;

// Unique if not exists validation rule.
class Unifne extends Unique
{
    protected $param;

    public function __construct(string $table, string $param = NULL, string $column = "NULL", string $idColumn = "id") {
        parent::__construct($table, $column);
        $this->idColumn = $idColumn;
        $this->param = $param;
    }

    public function __toString()
    {
        $idValue = 0;

        if (! empty($this->param)) {
            $idValue = app('request')->route()->parameters()[$this->param][$this->idColumn];
        }

        if (empty($idValue)) {
            $idValue = app('request')->all()[$this->idColumn];
        }

        return rtrim(sprintf('unique:%s,%s,%s,%s,%s',
            $this->table,
            $this->column,
            '"'.$idValue.'"',
            $this->idColumn,
            $this->formatWheres()
        ), ',');
    }
}