<?php

namespace TunaCMS\CommonComponent\Model;

interface BodyInterface
{
    /**
     * @param string $body
     *
     * @return self
     */
    public function setBody($body);

    /**
     * @return string
     */
    public function getBody();
}