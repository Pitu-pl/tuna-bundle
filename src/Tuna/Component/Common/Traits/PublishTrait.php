<?php

namespace TunaCMS\CommonComponent\Traits;

trait PublishTrait
{
    /**
     * @var string
     */
    protected $published;

    /**
     * @inheritdoc
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @inheritdoc
     */
    public function isPublished()
    {
        return $this->published;
    }
}