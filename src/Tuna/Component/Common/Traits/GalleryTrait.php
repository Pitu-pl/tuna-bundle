<?php

namespace TunaCMS\CommonComponent\Traits;

use TheCodeine\GalleryBundle\Entity\Gallery;

trait GalleryTrait
{
    /**
     * @var Gallery
     */
    protected $gallery;

    /**
     * @inheritdoc
     */
    public function setGallery(Gallery $gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getGallery()
    {
        return $this->gallery;
    }
}