<?php

namespace CMS\EAV\Domain\Repository;

use Illuminate\Support\Facades\DB;
use CMS\EAV\Domain\Entity\EAV;

class EAVRepository
{
    public function __construct(
        private EAV $eav
    ) {}

    public function insert(array $data)
    {
        return DB::transaction(function() use($data) {
            return $this->eav->insert($data);
        });
    }

    public function getAttributeValue(int $id)
    {
        return DB::transaction(function() use($id) {

            return $this->eav->select('attribute_value')->where('id', $id)->first();

        });
    }
}