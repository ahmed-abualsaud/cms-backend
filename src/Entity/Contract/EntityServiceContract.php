<?php

namespace CMS\Entity\Contract;

use CMS\Entity\Domain\Entity\Entity;

interface EntityServiceContract
{
    public function getOne(Entity $entity);

    public function getAll();

    public function create(array $createEntityDto);

    public function update(Entity $entity, array $updateEntityDto);

    public function updateByID(int $id, array $updateEntityDto);

    public function delete(Entity $entity);

    public function getEntityID(array $entity);

    public function getEntityName(array $entity);

    public function getEntityValidName(string $entity);

    public function getAllNames();

    public function getEntitiesTableName();

    public function getEntityRecordByName(string $name);
}