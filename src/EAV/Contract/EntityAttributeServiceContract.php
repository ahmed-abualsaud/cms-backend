<?php

namespace CMS\EAV\Contract;

interface EntityAttributeServiceContract
{
    public function assignAttributesToEntity(array $entity);

    public function getEntityAttributes(string $entityName);
}