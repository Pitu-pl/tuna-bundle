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
    public function getFormType(Page $page)
    {
        return $this->get('the_codeine_page.factory')->getFormInstance($page);
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
        return $this->getDoctrine()->getRepository($this->getParameter('the_codeine_page.model'));
    }
}