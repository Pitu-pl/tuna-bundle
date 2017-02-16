<?php

namespace TunaCMS\CommonComponent\Traits;

trait TypeTrait
{
    /**
     * @inheritdoc
     */
    public function getType()
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}