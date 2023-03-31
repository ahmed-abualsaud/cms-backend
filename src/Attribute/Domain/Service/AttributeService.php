<?php

namespace CMS\Attribute\Domain\Service;

use CMS\Attribute\Domain\Entity\Attribute;
use CMS\Attribute\Contract\AttributeServiceContract;
use CMS\Attribute\Domain\Repository\AttributeRepository;

class AttributeService implements AttributeServiceContract
{
    public function __construct(
        private AttributeRepository $attributeRepository
    ) {}

    public function getOne(Attribute $attribute)
    {
        return $attribute;
    }

    public function getAll()
    {
        return $this->attributeRepository->getAll();
    }

    public function create(array $createAttributeDto)
    {
        return $this->attributeRepository->create($createAttributeDto);
    }

    public function update(Attribute $attribute, array $updateAttributeDto)
    {
        return $this->attributeRepository->update($attribute->id, $updateAttributeDto);
    }

    public function delete(Attribute $attribute)
    {
        return $this->attributeRepository->delete($attribute->id);
    }

    public function getAttributeID(array $attribute)
    {
        if (array_key_exists("id", $attribute)) {
            $record = $this->attributeRepository->getOne($attribute["id"]);
            if (empty($record)) return;
            return $attribute["id"];
        }

        if (array_key_exists("name", $attribute)) {
            $record = $this->attributeRepository->getOneByName($attribute['name']);
            if (! empty($record)) return $record->id;
        }

        return null;
    }

    public function getAttributesByID(array $attributeID)
    {
        return $this->attributeRepository->getAttributesByID($attributeID);
    }

    public function getAttributesTableName()
    {
        return $this->attributeRepository->getAttributesTableName();
    }
}