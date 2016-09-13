<?php

namespace TheCodeine\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use TheCodeine\MenuBundle\Entity\Menu;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use TheCodeine\MenuBundle\EventListener\MenuListener;
use TheCodeine\MenuBundle\Form\MenuType;

/**
 * @Route("menu")
 */
class MenuController extends Controller
{
    /**
     * @Route("", name="tuna_menu_list")
     * @Template()
     */
    public function listAction(Request $request)
    {
        return array(
            'menus' => $this->getDoctrine()->getRepository('TheCodeineMenuBundle:Menu')->getMenuTree(),
        );
    }

    /**
     * @Route("/create", name="tuna_menu_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $menu = new Menu();
        $em = $this->getDoctrine()->getManager();

        if (($parentId = $request->query->get('parentId'))) {
            $menu->setParent($em->getReference('TheCodeineMenuBundle:Menu', $parentId));
        }
        if (($pageId = $request->query->get('pageId'))) {
            $page = $em->find('TheCodeinePageBundle:Page', $pageId);
            $menu->setPage($page);
            MenuListener::synchronizeWithPage($menu, $page);
        }

        $form = $this->createForm(MenuType::class, $menu);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($menu);
            $em->flush();

            return $this->redirectToRoute('tuna_menu_list');
        }

        return array(
            'form' => $form->createView(),
            'menu' => $menu,
            'pageTitlesMap' => $em->getRepository('TheCodeinePageBundle:Page')->getTitlesMap($this->getParameter('locale')),
        );
    }

    /**
     * @Route("/{id}/edit", name="tuna_menu_edit")
     * @Template()
     */
    public function editAction(Request $request, Menu $menu)
    {
        if ($menu->getParent() == null) {
            throw new AccessDeniedHttpException();
        }
        $form = $this->createForm(MenuType::class, $menu);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('tuna_menu_list');
        }

        return array(
            'form' => $form->createView(),
            'menu' => $menu,
            'pageTitlesMap' => $em->getRepository('TheCodeinePageBundle:Page')->getTitlesMap($this->getParameter('locale')),
        );
    }

    /**
     * @Route("/{id}/delete", name="tuna_menu_delete")
     */
    public function deleteAction(Request $request, Menu $menu)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($menu);
        $em->flush();

        return $this->redirectToRoute('tuna_menu_list');
    }

    /**
     * @Route("/save-order", name="tuna_menu_saveorder")
     * @Method("POST")
     */
    public function saveOrderAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $order = $request->request->get('order', array());
        $entities = $em->getRepository('TheCodeineMenuBundle:Menu')->findAll();
        $pages = array();

        foreach ($entities as $entity) {
            $pages[$entity->getId()] = $entity;
        }

        foreach ($order as $pageTreeData) {
            if (isset($pages[$pageTreeData['id']])) {
                $pages[$pageTreeData['id']]->setTreeData(
                    $pageTreeData['left'],
                    $pageTreeData['right'],
                    $pageTreeData['depth'],
                    isset($pages[$pageTreeData['parent_id']]) ? $pages[$pageTreeData['parent_id']] : null
                );
            }
        }
        $em->flush();

        return new JsonResponse('ok');
    }
}
