<?php

namespace CMS\EAV\App\HTTP\Controller;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;

use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Middleware;

use CMS\EAV\Contract\EAVServiceContract;
use CMS\Entity\Contract\EntityServiceContract;
use CMS\EAV\Contract\EntityAttributeServiceContract;

#[Prefix('api/eav/entity/{entity}')]
//#[Middleware('role:admin')]
class EAVController
{
    public function __construct(
        private EAVServiceContract $eavService,
        private EntityServiceContract $entityService,
        private EntityAttributeServiceContract $entityAttributeService
    ) {}

    #[Post('/')]
    public function addRecord(string $entity, Request $request)
    {
        // Validate Entity.
        $entityName = $this->entityService->getEntityValidName($entity);
        if (empty($entityName)) return failureJSONResponse("Invalid entity name: ".$entity, 400);

        // Validate Attributes.
        $attributes = $request->all();
        $entityAttributes = $this->entityAttributeService->getEntityAttributes($entityName);
        $error = $this->vaildateAttributes($entityAttributes, $attributes);
        if (! empty($error)) return failureJSONResponse($error, 400);

        // Prepare addRecord parameters.
        $entity = $this->entityService->getEntityRecordByName($entityName);
        foreach ($entityAttributes as $key => $entityAttribute) {
            if(array_key_exists($entityAttribute['name'], $attributes)) {
                $entityAttributes[$key] = array_merge($entityAttribute, ["value" => $attributes[$entityAttribute['name']]]);
            } else unset($entityAttributes[$key]);
        }

        return jsonResponse($this->eavService->addRecord($entity, $entityAttributes));
    }

    private function vaildateAttributes($entityAttributes, array $attributes)
    {
        $attributesNames = array_keys($attributes);

        // Verify that all given attributes are assigned to the given entity.
        $invalidAttrsNames = array_values(array_diff($attributesNames, Arr::pluck($entityAttributes, 'name')));
        if(! empty($invalidAttrsNames)) {
            return "Invalid attribute name: ".$invalidAttrsNames[0];
        }

        // Verify that all required attributes are given.
        $requiredAttrs = array_values(array_filter($entityAttributes,  function ($entityAttribute) {
            return $entityAttribute['nullable'] == false;
        }));

        $requiredAttrsNames = array_values(array_diff(Arr::pluck($requiredAttrs, 'name'), $attributesNames));
        if(! empty($requiredAttrsNames)) {
            return "The ".$requiredAttrsNames[0]." attribute is required";
        }

        // Verify that all unique attributes still unique.
        $uniqueAttrs = array_values(array_filter($entityAttributes,  function ($entityAttribute) use($attributes) {
            return $entityAttribute['unique'] == true && array_key_exists($entityAttribute['name'], $attributes);
        }));

        if(! empty($uniqueAttrs)) {
            foreach ($uniqueAttrs as $uniqueAttr) {
                $uniqueAttrValue = $this->eavService->getAttributeValue($uniqueAttr['entity_attribute_id']);
                if ($attributes[$uniqueAttr['name']] === castString($uniqueAttrValue, $uniqueAttr['type'])) {
                    return $uniqueAttr['name']." attribute must be unique";
                }
            }
        }

        // Verify that all given attributes data types are compatible with the actual data types.
        $invalidAttrsDataTypes = array_values(array_filter($entityAttributes, function($entityAttribute) use($attributes) {
            return (array_key_exists($entityAttribute['name'], $attributes) && 
                $entityAttribute['type'] !== gettype($attributes[$entityAttribute['name']]));
        }));

        if (! empty($invalidAttrsDataTypes)){
            return "The ".$invalidAttrsDataTypes[0]['name']." attribute must be a ".$invalidAttrsDataTypes[0]['type'];
        }

        return null;
    }
}