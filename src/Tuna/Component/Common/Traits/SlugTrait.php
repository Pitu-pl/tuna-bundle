<?php

namespace TunaCMS\CommonComponent\Traits;

trait SlugTrait
{
    /**
     * @var string
     */
    protected $slug;

    /**
     * @inheritdoc
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getSlug()
    {
        return $this->slug;
    }
}