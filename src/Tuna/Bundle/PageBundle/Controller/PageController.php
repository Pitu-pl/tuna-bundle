<?php

namespace TheCodeine\PageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use TunaCMS\PageComponent\Model\Page;

class PageController extends AbstractPageController
{
    /**
     * {@inheritDoc}
     */
    public function getNewPage()
    {
        return $this->get('the_codeine_page.factory')->getInstance();
    }

    /**
     * {@inheritDoc}
     */
    public function getFormType()
    {
        return $this->get('the_codeine_page.factory')->getFormInstance();
    }

    /**
     * {@inheritDoc}
     */
    public function getRedirectUrl(Request $request)
    {
        return $this->generateUrl('tuna_page_list');
    }

    /**
     * {@inheritDoc}
     */
    public function getRepository()
    {
        return $this->get('the_codeine_page.manager')->getRepository();
    }
}