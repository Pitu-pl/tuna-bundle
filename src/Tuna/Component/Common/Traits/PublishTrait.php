<?php

namespace TunaCMS\CommonComponent\Traits;

use Doctrine\ORM\Mapping as ORM;

trait PublishTrait
{
    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
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