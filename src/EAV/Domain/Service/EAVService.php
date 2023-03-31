<?php

namespace CMS\EAV\Domain\Service;

use CMS\EAV\Contract\EAVServiceContract;
use CMS\EAV\Domain\Repository\EAVRepository;
use CMS\Entity\Contract\EntityServiceContract;

class EAVService implements EAVServiceContract
{
    public function __construct(
        private EntityServiceContract $entityService,
        private EAVRepository $eavRepository
    ) {}

    public function addRecord(array $entity, array $attributes)
    {
        $data = [];
        ++$entity['last_id'];

        foreach ($attributes as $attribute) {
            $data[] = [
                'entity_attribute_id' => $attribute['entity_attribute_id'],
                'attribute_value' => $attribute['value'],
                'record_id' => $entity['last_id']
            ];
        }

        $data = $this->eavRepository->insert($data);
        $entity = $this->entityService->updateByID($entity['id'], ['last_id' => $entity['last_id']]);

        return [$entity, $data];
    }

    public function getAttributeValue(int $id)
    {
        $value = $this->eavRepository->getAttributeValue($id);
        if (! empty($value)) return $value->attribute_value;
        return null;
    }
}