<?php

namespace TunaCMS\CommonComponent\Model;

interface TeaserInterface
{
    /**
     * @param string $teaser
     *
     * @return self
     */
    public function setTeaser($teaser);

    /**
     * @return string
     */
    public function getTeaser();
}