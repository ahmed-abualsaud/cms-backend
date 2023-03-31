<?php

namespace CMS\Entity\Domain\Repository;

use Illuminate\Support\Facades\DB;
use CMS\Entity\Domain\Entity\Entity;

class EntityRepository
{
    public function __construct(
        private Entity $entity
    ) {}

    public function getAll()
    {
        return DB::transaction(function() {

            return $this->entity->all()->toArray();

        });
    }

    public function create(array $createEntityDto)
    {
        return DB::transaction(function() use($createEntityDto) {

            return $this->entity->create($createEntityDto);

        });
    }

    public function update(int $id, array $updateEntityDto)
    {
        return DB::transaction(function() use($id, $updateEntityDto) {

            $query = $this->entity->where('id', $id);
            $query->update($updateEntityDto);
            return $query->get();

        });
    }

    public function delete(int $id)
    {
        return DB::transaction(function() use($id) {

            return $this->entity->where('id', $id)->delete();

        });
    }

    public function getOneByID(string $id)
    {
        return DB::transaction(function() use($id) {

            return $this->entity->select('name')->where('id', $id)->first();

        });
    }

    public function getOneByName(string $name)
    {
        return DB::transaction(function() use($name) {

            return $this->entity->select('id')->where('name', $name)->first();

        });
    }

    public function getAllNames()
    {
        return DB::transaction(function() {

            return $this->entity->select('name')->get()->pluck('name')->toArray();

        });
    }

    public function getEntitiesTableName()
    {
        return $this->entity->getTable();
    }

    public function getEntityRecordByName(string $name)
    {
        return DB::transaction(function() use($name) {

            return $this->entity->where('name', $name)->first()->toArray();

        });
    }
}