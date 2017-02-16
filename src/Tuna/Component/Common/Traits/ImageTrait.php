<?php

namespace TunaCMS\CommonComponent\Traits;

use TheCodeine\ImageBundle\Entity\Image;

trait ImageTrait
{
    /**
     * @var Image
     */
    protected $image;

    /**
     * @inheritdoc
     */
    public function setImage(Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getImage()
    {
        return $this->image;
    }
}