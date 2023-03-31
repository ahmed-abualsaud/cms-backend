<?php

namespace CMS\EAV\Domain\Repository;

use Illuminate\Support\Facades\DB;
use CMS\EAV\Domain\Entity\EntityAttribute;

class EntityAttributeRepository
{
    public function __construct(
        private EntityAttribute $entityAttribute
    ) {}

    public function getEntity()
    {
        return $this->entityAttribute;
    }

    public function getOne(int $entityID, int $attributeID)
    {
        return DB::transaction(function() use($entityID, $attributeID) {

            return $this->entityAttribute->where('entity_id', $entityID)->where('attribute_id', $attributeID)->first();

        });
    }

    public function create(array $createEntityAttributeDto)
    {
        return DB::transaction(function() use($createEntityAttributeDto) {

            return $this->entityAttribute->create($createEntityAttributeDto);

        });
    }

    public function getEntityAttributes(string $entityName, string $entitiesTable, string $attributesTable)
    {
        return DB::transaction(function() use($entityName, $entitiesTable, $attributesTable) {

            return $this->entityAttribute
            ->join($entitiesTable, $this->getEntityAttributesTableName().'.entity_id', $entitiesTable.'.id')
            ->join($attributesTable, $this->getEntityAttributesTableName().'.attribute_id', $attributesTable.'.id')
            ->select(
                $this->getEntityAttributesTableName().'.id as entity_attribute_id', 
                $attributesTable.'.id as attribute_id', $attributesTable.'.name', 
                $attributesTable.'.type', $attributesTable.'.nullable', $attributesTable.'.unique'
            )
            ->where($entitiesTable.'.name', $entityName)
            ->get()->toArray();

        });
    }

    public function getEntityAttributesTableName()
    {
        return $this->entityAttribute->getTable();
    }
}