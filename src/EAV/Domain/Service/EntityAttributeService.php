<?php

namespace CMS\EAV\Domain\Service;

use Illuminate\Support\Arr;

use CMS\Entity\Contract\EntityServiceContract;
use CMS\Attribute\Contract\AttributeServiceContract;
use CMS\EAV\Contract\EntityAttributeServiceContract;
use CMS\EAV\Domain\Repository\EntityAttributeRepository;

class EntityAttributeService implements EntityAttributeServiceContract
{
    public function __construct(
        private EntityServiceContract $entityService,
        private AttributeServiceContract $attributeService,
        private EntityAttributeRepository $entityAttributeRepository
    ) {}

    public function getEntityAttributes(string $entityName)
    {
        return $this->entityAttributeRepository->getEntityAttributes(
            $entityName,
            $this->entityService->getEntitiesTableName(),
            $this->attributeService->getAttributesTableName(),
        );
    }

    public function assignAttributesToEntity(array $assignAttributesDto)
    {
        $attributes = $assignAttributesDto['attributes'];
        $entity = Arr::only($assignAttributesDto, ['entityID', 'entityName']);
        $entityID = $this->entityService->getEntityID($entity);

        if (empty($entityID)) {
            return buildException(400, "A valid entity id or name is required");
        }

        if (isAssoc($attributes)) {
            return $this->getEntityAttributeRecord($entityID, $attributes);
        }

        $errors = [];
        $attributeIDs = [];

        foreach ($attributes as $attribute) {
            $record = $this->getEntityAttributeRecord($entityID, $attribute);
            if (! empty($record['error'])) $errors[] = $record['error'];
            if (! empty($record['attributeID'])) $attributeIDs[] =  $record['attributeID'];
        }

        return [
            'entityName' => $this->entityService->getEntityName($entity),
            'attributes' => $this->attributeService->getAttributesByID($attributeIDs),
            'attributesAssigningErrors' => $errors
        ];

    }

    private function getEntityAttributeRecord(int $entityID, array $attribute)
    {
        $attributeID = $this->attributeService->getAttributeID($attribute);
        if (empty($attributeID)) {
            return [
                'attributeID' => null,
                'error' => array_key_exists("name", $attribute)? 
                    "Attribute with name = ".$attribute['name']." does not exists" :
                    "Attribute with id = ".(array_key_exists("id", $attribute)? $attribute['id'] : "NULL")." does not exists"
            ];
        }
        
        $record = $this->entityAttributeRepository->getOne($entityID, $attributeID);
        if (! empty($record)) {
            return [
                'attributeID' => $record->attribute_id,
                'error' => null
            ];
        }

        return [
            'attributeID' => $this->entityAttributeRepository->create(['entity_id' => $entityID, 'attribute_id' => $attributeID])->attribute_id,
            'error' => null
        ];
    }
}