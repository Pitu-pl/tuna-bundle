<?php

namespace TunaCMS\CommonComponent\Model;

interface SlugInterface
{
    /**
     * @param string $slug
     *
     * @return self
     */
    public function setSlug($slug);

    /**
     * @return string
     */
    public function getSlug();
}