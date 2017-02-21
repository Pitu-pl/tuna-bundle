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
    private $form;

    /**
     * @var string
     */
    private $model;

    /**
     * PageFactory constructor.
     *
     * @param string $form
     * @param string $model
     */
    public function __construct($form, $model)
    {
        $this->form = $form;
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
     * @return string
     */
    public function getFormInstance()
    {
        return $this->form;
    }
}