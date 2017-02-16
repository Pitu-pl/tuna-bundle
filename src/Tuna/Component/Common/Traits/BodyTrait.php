<?php

namespace TunaCMS\CommonComponent\Traits;

trait BodyTrait
{
    /**
     * @var string
     */
    protected $body;

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