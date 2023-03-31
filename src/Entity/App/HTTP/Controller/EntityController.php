<?php

namespace CMS\Entity\App\HTTP\Controller;

use CMS\Entity\Domain\Entity\Entity;
use CMS\Entity\App\HTTP\DTO\CreateEntityDto;
use CMS\Entity\App\HTTP\DTO\UpdateEntityDto;
use CMS\Entity\Contract\EntityServiceContract;

use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Put;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Middleware;


#[Prefix('api/entities')]
#[Middleware('role:admin')]
class EntityController 
{
    public function __construct(
        private EntityServiceContract $entityService
    ) {}

    #[Get('/{entity}')]
    public function getOne(Entity $entity)
    {
        return jsonResponse($this->entityService->getOne($entity));
    }

    #[Get('/')]
    public function getAll()
    {
        return jsonResponse($this->entityService->getAll());
    }

    #[Post('/')]
    public function create(CreateEntityDto $createEntityDto)
    {
        return jsonResponse($this->entityService->create($createEntityDto->toArray()));
    }

    #[Put('/{entity}')]
    public function update(Entity $entity, UpdateEntityDto $updateEntityDto)
    {
        return jsonResponse($this->entityService->update($entity, $updateEntityDto->toArray()));
    }

    #[Delete('/{entity}')]
    public function delete(Entity $entity)
    {
        return jsonResponse($this->entityService->delete($entity));
    }    
}