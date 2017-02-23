<?php

namespace TunaCMS\CommonComponent\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait TeaserTrait
{
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Gedmo\Translatable
     */
    private $teaser;

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