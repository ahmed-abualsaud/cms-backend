<?php

namespace CMS\Attribute\App\HTTP\Controller;

use CMS\Attribute\Domain\Entity\Attribute;
use CMS\Attribute\App\HTTP\DTO\CreateAttributeDto;
use CMS\Attribute\App\HTTP\DTO\UpdateAttributeDto;
use CMS\Attribute\Contract\AttributeServiceContract;

use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Put;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Middleware;


#[Prefix('api/attributes')]
#[Middleware('role:admin')]
class AttributeController 
{
    public function __construct(
        private AttributeServiceContract $attributeService
    ) {}

    #[Get('/{attribute}')]
    public function getOne(Attribute $attribute)
    {
        return jsonResponse($this->attributeService->getOne($attribute));
    }

    #[Get('/')]
    public function getAll()
    {
        return jsonResponse($this->attributeService->getAll());
    }

    #[Post('/')]
    public function create(CreateAttributeDto $createAttributeDto)
    {
        return jsonResponse($this->attributeService->create($createAttributeDto->toArray()));
    }

    #[Put('/{attribute}')]
    public function update(Attribute $attribute, UpdateAttributeDto $updateAttributeDto)
    {
        return jsonResponse($this->attributeService->update($attribute, $updateAttributeDto->toArray()));
    }

    #[Delete('/{attribute}')]
    public function delete(Attribute $attribute)
    {
        return jsonResponse($this->attributeService->delete($attribute));
    }    
}