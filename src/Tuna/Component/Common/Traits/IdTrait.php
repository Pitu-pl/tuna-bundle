<?php

namespace TunaCMS\CommonComponent\Traits;

trait IdTrait
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }
}