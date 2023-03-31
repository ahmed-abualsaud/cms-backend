<?php

namespace CMS\Attribute\Contract;

use CMS\Attribute\Domain\Entity\Attribute;

interface AttributeServiceContract
{
    public function getOne(Attribute $attribute);

    public function getAll();

    public function create(array $createAttributeDto);

    public function update(Attribute $attribute, array $updateAttributeDto);

    public function delete(Attribute $attribute);

    public function getAttributeID(array $attribute);

    public function getAttributesByID(array $attributeID);

    public function getAttributesTableName();
}