<?php

namespace TunaCMS\CommonComponent\Traits;

trait AliasTrait
{
    /**
     * @var string
     */
    protected $alias;

    /**
     * @inheritdoc
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAlias()
    {
        return $this->alias;
    }
}