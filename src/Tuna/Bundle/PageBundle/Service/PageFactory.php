<?php

namespace TheCodeine\PageBundle\Service;

use TheCodeine\PageBundle\Form\CategoryPageType;
use TheCodeine\PageBundle\Form\PageType;
use TunaCMS\PageComponent\Model\CategoryPage;
use TunaCMS\PageComponent\Model\PageInterface;

class PageFactory
{
    /**
     * @var string
     */
    protected $model;

    /**
     * PageFactory constructor.
     *
     * @param string $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getInstance()
    {
        return new $this->model();
    }

    /**
     * @param PageInterface|null $pageInterface
     *
     * @return CategoryPageType|PageType
     */
    public function getFormInstance(PageInterface $pageInterface = null)
    {
        switch (true) {
            case $pageInterface instanceof CategoryPage:
                return CategoryPageType::class;
            default:
                return PageType::class;
        }
    }
}