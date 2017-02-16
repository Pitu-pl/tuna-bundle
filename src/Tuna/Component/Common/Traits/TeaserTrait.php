<?php

namespace TunaCMS\CommonComponent\Traits;

trait TeaserTrait
{
    /**
     * @var string
     */
    protected $teaser;

    /**
     * @inheritdoc
     */
    public function setTeaser($teaser)
    {
        $this->teaser = $teaser;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTeaser()
    {
        return $this->teaser;
    }
}