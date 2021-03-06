<?php

namespace TheCodeine\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use TheCodeine\PageBundle\Controller\PageController as Controller;
use TheCodeine\MenuBundle\Entity\Menu;
use TheCodeine\PageBundle\Entity\AbstractPage;

/**
 * @Route("/page")
 */
class PageController extends Controller
{
    const PAGINATE_LIMIT = 10;

    /**
     * {@inheritDoc}
     */
    public function getRedirectUrl(Request $request)
    {
        if ($request->query->get('redirect') == 'dashboard') {
            return $this->generateUrl('tuna_admin_dashboard');
        }

        return parent::getRedirectUrl($request);
    }

    /**
     * @Route("/list", name="tuna_page_list")
     * @Template()
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(AbstractPage::class)->getListQuery();
        $menuMap = $em->getRepository(Menu::class)->getPageMap();
        $page = $request->get('page', 1);

        return [
            'offset' => ($page - 1) * self::PAGINATE_LIMIT,
            'menuMap' => $menuMap,
            'pagination' => $this->get('knp_paginator')->paginate($query, $page, self::PAGINATE_LIMIT),
        ];
    }

    /**
     * @Route("/create", name="tuna_page_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $this->denyAccessUnlessGranted('create', 'pages');

        $abstractPage = $this->getNewPage();
        $form = $this->createForm($this->getFormType($abstractPage), $abstractPage);

        // TODO: Move this to twig
        $form->add('save', SubmitType::class, [
            'label' => 'ui.form.labels.save'
        ]);

        if (($parentId = $request->query->get('menuParentId'))) {
            $menuParent = $this->getDoctrine()->getManager()->getReference(Menu::class, $parentId);
        }

        $return = $this->handleCreate($request, $form, $abstractPage);

        if ($form->isValid() && !$request->isXmlHttpRequest() && isset($menuParent)) {
            $this->createMenuForPage($menuParent, $abstractPage);
        }

        return $return;
    }

    /**
     * @Route("/{id}/delete", name="tuna_page_delete", requirements={"id" = "\d+"})
     * @Template()
     */
    public function deleteAction(Request $request, AbstractPage $abstractPage)
    {
        $this->denyAccessUnlessGranted('delete', 'pages');

        return parent::deleteAction($request, $abstractPage);
    }

    /**
     * @Route("/add-to-menu", name="tuna_page_add_to_menu")
     */
    public function createMenuItemAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getReference(AbstractPage::class, $request->request->get('pageId'));
        $menuParent = $em->getReference(Menu::class, $request->request->get('menuParentId'));

        $this->createMenuForPage($menuParent, $page);

        return new JsonResponse('ok');
    }

    /**
     * @param Menu $menuParent
     * @param AbstractPage $abstractPage
     */
    private function createMenuForPage(Menu $menuParent, AbstractPage $abstractPage)
    {
        $em = $this->getDoctrine()->getManager();
        $menu = new Menu('tmp');
        $menu->setPage($abstractPage);
        $menu->setParent($menuParent);
        $em->persist($menu);
        $em->flush();
    }
}
