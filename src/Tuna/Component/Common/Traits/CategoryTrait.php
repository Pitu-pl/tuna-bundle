<?php

namespace TunaCMS\CommonComponent\Traits;

use TheCodeine\CategoryBundle\Entity\Category;

trait CategoryTrait
{
    /**
     * @var Category
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