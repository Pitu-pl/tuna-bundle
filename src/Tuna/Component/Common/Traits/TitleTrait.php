<?php

namespace TunaCMS\CommonComponent\Traits;

trait TitleTrait
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @inheritdoc
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return $this->title;
    }
}