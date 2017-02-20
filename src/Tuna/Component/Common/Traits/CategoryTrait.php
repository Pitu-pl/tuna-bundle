<?php

namespace TunaCMS\CommonComponent\Traits;

use Doctrine\ORM\Mapping as ORM;
use TheCodeine\CategoryBundle\Entity\Category;

trait CategoryTrait
{
    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="TheCodeine\CategoryBundle\Entity\Category")
     */
    protected $category;

    /**
     * @inheritdoc
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCategory()
    {
        return $this->category;
    }
}