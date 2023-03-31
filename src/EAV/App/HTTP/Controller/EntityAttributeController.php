<?php

namespace CMS\EAV\App\HTTP\Controller;

use CMS\EAV\App\HTTP\DTO\AssignAttributesDto;
use CMS\EAV\Contract\EntityAttributeServiceContract;

use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Middleware;


#[Prefix('api/eav')]
#[Middleware('role:admin')]
class EntityAttributeController 
{
    public function __construct(
        private EntityAttributeServiceContract $entityService
    ) {}

    #[Post('/assign-attributes')]
    public function assignAttributesToEntity(AssignAttributesDto $assignAttributesDto)
    {
        return jsonResponse($this->entityService->assignAttributesToEntity($assignAttributesDto->toArray()));
    }   
}