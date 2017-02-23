<?php

namespace TheCodeine\PageBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use TunaCMS\CommonComponent\Model\AttachmentInterface;
use TunaCMS\CommonComponent\Model\GalleryInterface;
use TunaCMS\PageComponent\Model\AbstractPage;

abstract class AbstractPageController extends Controller
{
    /**
     * @return AbstractPage
     */
    abstract public function getNewPage();

    /**
     * @return string
     */
    abstract public function getFormType();

    /**
     * @param Request $request
     *
     * @return string
     */
    abstract public function getRedirectUrl(Request $request);

    /**
     * @return EntityRepository
     */
    abstract public function getRepository();

    /**
     * @Route("/list", name="tuna_page_list")
     * @Template()
     */
    public function listAction(Request $request)
    {
        return [
            'entities' => $this->getRepository()->findAll(),
        ];
    }

    /**
     * @Route("/create", name="tuna_page_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $page = $this->getNewPage();
        $form = $this->createForm($this->getFormType(), $page);

        // TODO: Move this to twig
        $form->add('save', SubmitType::class, [
            'label' => 'ui.form.labels.save'
        ]);

        return $this->handleCreate($request, $form, $page);
    }

    /**
     * @Route("/{id}/edit", name="tuna_page_edit", requirements={"id" = "\d+"})
     * @Template()
     * @ParamConverter()
     */
    public function editAction(Request $request, AbstractPage $page)
    {
        $originalAttachments = new ArrayCollection();
        if ($page instanceof AttachmentInterface) {
            foreach ($page->getAttachments() as $attachment) {
                $originalAttachments[] = $attachment;
            }
        }

        $originalGalleryItems = new ArrayCollection();
        if ($page instanceof GalleryInterface) {
            if ($page->getGallery()) {
                foreach ($page->getGallery()->getItems() as $item) {
                    $originalGalleryItems[] = $item;
                }
            }
        }

        $form = $this->createForm($this->getFormType(), $page);

        // TODO: Move this to twig
        $form->add('save', SubmitType::class, [
            'label' => 'ui.form.labels.save'
        ]);

        return $this->handleEdit($request, $form, $page, $originalAttachments, $originalGalleryItems);
    }

    /**
     * @Route("/{id}/delete", name="tuna_page_delete", requirements={"id" = "\d+"})
     * @Template()
     */
    public function deleteAction(Request $request, AbstractPage $page)
    {
        return $this->handleDelete($request, $page);
    }

    /**
     * @param Request $request
     * @param Form $form
     * @param AbstractPage $page
     *
     * @return array|RedirectResponse
     */
    protected function handleCreate(Request $request, Form $form, AbstractPage $page)
    {
        $form->handleRequest($request);

        if ($form->isValid() && !$request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirect($this->getRedirectUrl($request));
        }

        return [
            'page' => $page,
            'form' => $form->createView()
        ];
    }

    /**
     * @param Request $request
     * @param Form $form
     * @param AbstractPage $page
     * @param ArrayCollection $originalAttachments
     * @param ArrayCollection $originalGalleryItems
     *
     * @return array|RedirectResponse
     */
    protected function handleEdit(Request $request, Form $form, AbstractPage $page, ArrayCollection $originalAttachments, ArrayCollection $originalGalleryItems)
    {
        $form->handleRequest($request);

        if ($form->isValid() && !$request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();

            if ($page instanceof AttachmentInterface) {
                foreach ($originalAttachments as $attachment) {
                    if (false === $page->getAttachments()->contains($attachment)) {
                        $em->remove($attachment);
                    }
                }
            }

            if ($page instanceof GalleryInterface) {
                foreach ($originalGalleryItems as $item) {
                    if (false === $page->getGallery()->getItems()->contains($item)) {
                        $em->remove($item);
                    }
                }
            }

            $em->persist($page);
            $em->flush();

            return $this->redirect($this->getRedirectUrl($request));
        }

        return [
            'page' => $page,
            'form' => $form->createView()
        ];
    }

    /**
     * @param Request $request
     * @param AbstractPage $page
     *
     * @return RedirectResponse
     */
    protected function handleDelete(Request $request, AbstractPage $page)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($page);
        $em->flush();

        return $this->redirect($this->getRedirectUrl($request));
    }
}