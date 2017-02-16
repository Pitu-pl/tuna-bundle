<?php

namespace TunaCMS\CommonComponent\Model;

interface TitleInterface
{
    /**
     * @param string $title
     *
     * @return self
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getTitle();
}