<?php

namespace CMS\EAV\Contract;


interface EAVServiceContract
{
    public function addRecord(array $entity, array $attributes);

    public function getAttributeValue(int $id);


}