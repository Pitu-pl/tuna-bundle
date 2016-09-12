<?php

namespace TheCodeine\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use TheCodeine\MenuBundle\Controller\AdminController as MenuAdminController;
use TheCodeine\MenuBundle\Entity\Menu;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("menu")
 */
class MenuController extends MenuAdminController
{
    protected function getRedirect(Menu $menu)
    {
        return $this->redirectToRoute('tuna_menu_list');
    }

    /**
     * @Route("", name="tuna_menu_list")
     * @Template()
     */
    public function listAction(Request $request)
    {
        return parent::listAction($request);
    }

    /**
     * @Route("/create", name="tuna_menu_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        return parent::createAction($request);
    }

    /**
     * @Route("/{id}/edit", name="tuna_menu_edit")
     * @Template()
     */
    public function editAction(Request $request, Menu $menu)
    {
        return parent::editAction($request, $menu);
    }

    /**
     * @Route("/save-order", name="tuna_menu_saveorder")
     * @Method("POST")
     */
    public function saveOrderAction(Request $request)
    {
        return parent::saveOrderAction($request);
    }

    /**
     * @Route("/{id}/delete", name="tuna_menu_delete")
     */
    public function deleteAction(Request $request, Menu $menu)
    {
        return parent::deleteAction($request, $menu);
    }

    /**
     * @Route("/reset", name="tuna_menu_reset")
     */
    public function resetAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//        $menu = $em->getRepository('TheCodeineMenuBundle:Menu')->findAll();
//        foreach ($menu as $item) {
//            $em->remove($item);
//        }
//        $em->flush();

        $root = new Menu('Czwarte menu');
        $em->persist($root);
        $em->flush();

        return $this->redirectToRoute('tuna_menu_list');
    }
}
