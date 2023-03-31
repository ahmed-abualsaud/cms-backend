<?php

namespace CMS\Attribute\Domain\Repository;

use Illuminate\Support\Facades\DB;
use CMS\Attribute\Domain\Entity\Attribute;

class AttributeRepository
{
    public function __construct(
        private Attribute $attribute
    ) {}

    public function getOne(int $id)
    {
        return $this->attribute->where('id', $id)->first();
    }

    public function getAll()
    {
        return DB::transaction(function() {

            return $this->attribute->all()->toArray();

        });
    }

    public function create(array $createAttributeDto)
    {
        return DB::transaction(function() use($createAttributeDto) {

            return $this->attribute->create($createAttributeDto);

        });
    }

    public function update(int $id, array $updateAttributeDto)
    {
        return DB::transaction(function() use($id, $updateAttributeDto) {

            $query = $this->attribute->where('id', $id);
            $query->update($updateAttributeDto);
            return $query->get();

        });
    }

    public function delete(int $id)
    {
        return DB::transaction(function() use($id) {

            return $this->attribute->where('id', $id)->delete();

        });
    }

    public function getOneByName(string $name)
    {
        return $this->attribute->select('id')->where('name', $name)->first();
    }

    public function getAttributesByID(array $attributeID)
    {
        return $this->attribute->select('name', 'type', 'nullable')->whereIn('id', $attributeID)->get();
    }

    public function getAttributesTableName()
    {
        return $this->attribute->getTable();
    }
}