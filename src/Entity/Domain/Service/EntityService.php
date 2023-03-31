<?php

namespace CMS\Entity\Domain\Service;

use CMS\Entity\Domain\Entity\Entity;
use CMS\Entity\Contract\EntityServiceContract;
use CMS\Entity\Domain\Repository\EntityRepository;

class EntityService implements EntityServiceContract
{
    public function __construct(
        private EntityRepository $entityRepository
    ) {}

    public function getOne(Entity $entity)
    {
        return $entity;
    }

    public function getAll()
    {
        return $this->entityRepository->getAll();
    }

    public function create(array $createEntityDto)
    {
        return $this->entityRepository->create($createEntityDto);
    }

    public function update(Entity $entity, array $updateEntityDto)
    {
        return $this->entityRepository->update($entity->id, $updateEntityDto);
    }

    public function updateByID(int $id, array $updateEntityDto)
    {
        return $this->entityRepository->update($id, $updateEntityDto);
    }

    public function delete(Entity $entity)
    {
        return $this->entityRepository->delete($entity->id);
    }

    public function getEntityID(array $entity)
    {
        if (array_key_exists("entityID", $entity)) {
            return $entity["entityID"];
        }

        if (array_key_exists("entityName", $entity)) {
            $record = $this->entityRepository->getOneByName($entity['entityName']);
            if (! empty($record)) return $record->id;
        }

        return null;
    }

    public function getEntityName(array $entity)
    {
        if (array_key_exists("entityName", $entity)) {
            return $entity["entityName"];
        }

        if (array_key_exists("entityID", $entity)) {
            $record = $this->entityRepository->getOneByID($entity['entityID']);
            if (! empty($record)) return $record->name;
        }

        return null;
    }

    public function getEntityValidName(string $entity)
    {
        $entity = strToSingular(strtolower($entity));
        $entities = $this->getAllNames();
        $entityName = null;

        foreach ($entities as $enti) {
            if ($entity === strToSingular(strtolower($enti))) {
                $entityName = $enti;
                break;
            }
        }
        return $entityName;
    }

    public function getAllNames()
    {
        return $this->entityRepository->getAllNames();
    }

    public function getEntitiesTableName()
    {
        return $this->entityRepository->getEntitiesTableName();
    }

    public function getEntityRecordByName(string $name)
    {
        return $this->entityRepository->getEntityRecordByName($name);
    }
}