<?php

namespace TheCodeine\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use TheCodeine\MenuBundle\Entity\Menu;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use TheCodeine\MenuBundle\EventListener\MenuListener;
use TheCodeine\MenuBundle\Form\MenuType;
use TunaCMS\PageComponent\Model\PageInterface;

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
        return [
            'menus' => $this->getDoctrine()->getRepository('TheCodeineMenuBundle:Menu')->getMenuTree(null, false),
        ];
    }

    /**
     * @Route("/create", name="tuna_menu_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $menu = new Menu();

        if (($parentId = $request->query->get('parentId'))) {
            $menu->setParent($em->getReference(Menu::class, $parentId));
        }

        if (($pageId = $request->query->get('pageId'))) {
            $page = $em->find(PageInterface::class, $pageId);
            $menu->setPage($page);
            MenuListener::synchronizeWithPage($menu, $page);
        }

        $form = $this->createForm(MenuType::class, $menu);
        $form->add('save', SubmitType::class, [
            'label' => 'ui.form.labels.save'
        ]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($menu);
            $em->flush();

            return $this->redirectToRoute('tuna_menu_list');
        }

        return [
            'form' => $form->createView(),
            'menu' => $menu,
            'pageTitlesMap' => $em->getRepository(PageInterface::class)->getTitlesMap($this->getParameter('locale')),
        ];
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
        $form->add('save', SubmitType::class, [
            'label' => 'ui.form.labels.save'
        ]);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('tuna_menu_list');
        }

        return [
            'form' => $form->createView(),
            'menu' => $menu,
            'pageTitlesMap' => $em->getRepository(PageInterface::class)->getTitlesMap($this->getParameter('locale')),
        ];
    }

    /**
     * @Route("/{id}/delete", name="tuna_menu_delete")
     */
    public function deleteAction(Request $request, Menu $menu)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($menu);
        $em->flush();

        return $this->redirectToRoute(
            $request->query->get('redirect') == 'dashboard' ?
                'tuna_admin_dashboard' :
                'tuna_menu_list'
        );
    }

    /**
     * @Route("/save-order", name="tuna_menu_saveorder")
     * @Method("POST")
     */
    public function saveOrderAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('TheCodeineMenuBundle:Menu');

        $order = $request->request->get('order', []);
        $entities = $repository->findAll();
        $nodes = [];

        foreach ($entities as $entity) {
            $nodes[$entity->getId()] = $entity;
        }

        foreach ($order as $nodeTreeData) {
            $nodes[(int)$nodeTreeData['id']]->setTreeData(
                (int)$nodeTreeData['left'],
                (int)$nodeTreeData['right'],
                (int)$nodeTreeData['depth'],
                isset($nodes[$nodeTreeData['parent_id']]) ? $nodes[$nodeTreeData['parent_id']] : null
            );
        }

        $em->flush();

        return new JsonResponse('ok');
    }

    /**
     * @Route("/override-this/{slug}", requirements={"slug"=".+"}, name="tuna_menu_item")
     * @Template()
     */
    public function pageAction(Menu $menu)
    {
        if (!$menu->isPublished() || !$menu->getPage()) {
            throw new NotFoundHttpException();
        }

        return [
            'page' => $menu->getPage(),
        ];
    }
}
