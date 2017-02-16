<?php

namespace TunaCMS\CommonComponent\Model;

use TheCodeine\FileBundle\Entity\Image;

interface ImageInterface
{
    /**
     * @param Image $image
     *
     * @return self
     */
    public function setImage(Image $image);

    /**
     * @return Image
     */
    public function getImage();
}