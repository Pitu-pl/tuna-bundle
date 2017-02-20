<?php

namespace TheCodeine\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/")
 */
class DashboardController extends Controller
{
    const PAGINATE_LIMIT = 10;

    /**
     * @Route("", name="tuna_admin_dashboard")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $page = $request->get('page', 1);
        $menuManager = $this->get('the_codeine_menu.manager');

        return [
            'menus' => $menuManager->getMenuTree(null, false),
            'offset' => ($page - 1) * self::PAGINATE_LIMIT,
            'pagination' => $this->get('knp_paginator')->paginate(
                $menuManager->getStandalonePagesPaginationQuery($this->getParameter('the_codeine_page.model')),
                $page, self::PAGINATE_LIMIT
            )
        ];
    }
}
