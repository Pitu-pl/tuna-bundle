<?php

namespace TunaCMS\CommonComponent\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait BodyTrait
{
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Gedmo\Translatable
     */
    private $body;

    /**
     * @inheritdoc
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getBody()
    {
        return $this->body;
    }
}