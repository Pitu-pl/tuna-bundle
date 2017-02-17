<?php

namespace TheCodeine\PageBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use TheCodeine\PageBundle\Form\AbstractPageType;
use TunaCMS\PageComponent\Model\PageInterface;

abstract class AbstractPageController extends Controller
{
    /**
     * @return PageInterface
     */
    abstract public function getNewPage();

    /**
     * @param PageInterface $pageInterface
     *
     * @return AbstractPageType
     */
    abstract public function getFormType(PageInterface $pageInterface);

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
        $pageInterface = $this->getNewPage();
        $form = $this->createForm($this->getFormType($pageInterface), $pageInterface);

        // TODO: Move this to twig
        $form->add('save', SubmitType::class, [
            'label' => 'ui.form.labels.save'
        ]);

        return $this->handleCreate($request, $form, $pageInterface);
    }

    /**
     * @Route("/{id}/edit", name="tuna_page_edit", requirements={"id" = "\d+"})
     * @Template()
     */
    public function editAction(Request $request, PageInterface $pageInterface)
    {
        $originalAttachments = new ArrayCollection();
        foreach ($pageInterface->getAttachments() as $attachment) {
            $originalAttachments[] = $attachment;
        }

        $originalGalleryItems = new ArrayCollection();
        if ($pageInterface->getGallery()) {
            foreach ($pageInterface->getGallery()->getItems() as $item) {
                $originalGalleryItems[] = $item;
            }
        }

        $form = $this->createForm($this->getFormType($pageInterface), $pageInterface);

        // TODO: Move this to twig
        $form->add('save', SubmitType::class, [
            'label' => 'ui.form.labels.save'
        ]);

        return $this->handleEdit($request, $form, $pageInterface, $originalAttachments, $originalGalleryItems);
    }

    /**
     * @Route("/{id}/delete", name="tuna_page_delete", requirements={"id" = "\d+"})
     * @Template()
     */
    public function deleteAction(Request $request, PageInterface $pageInterface)
    {
        return $this->handleDelete($request, $pageInterface);
    }

    /**
     * @param Request $request
     * @param Form $form
     * @param PageInterface $pageInterface
     *
     * @return array|RedirectResponse
     */
    protected function handleCreate(Request $request, Form $form, PageInterface $pageInterface)
    {
        $form->handleRequest($request);

        if ($form->isValid() && !$request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pageInterface);
            $em->flush();

            return $this->redirect($this->getRedirectUrl($request));
        }

        return [
            'page' => $pageInterface,
            'form' => $form->createView()
        ];
    }

    /**
     * @param Request $request
     * @param Form $form
     * @param PageInterface $pageInterface
     * @param ArrayCollection $originalAttachments
     * @param ArrayCollection $originalGalleryItems
     *
     * @return array|RedirectResponse
     */
    protected function handleEdit(Request $request, Form $form, PageInterface $pageInterface, ArrayCollection $originalAttachments, ArrayCollection $originalGalleryItems)
    {
        $form->handleRequest($request);

        if ($form->isValid() && !$request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();

            foreach ($originalAttachments as $attachment) {
                if (false === $pageInterface->getAttachments()->contains($attachment)) {
                    $em->remove($attachment);
                }
            }

            foreach ($originalGalleryItems as $item) {
                if (false === $pageInterface->getGallery()->getItems()->contains($item)) {
                    $em->remove($item);
                }
            }

            $em->persist($pageInterface);
            $em->flush();

            return $this->redirect($this->getRedirectUrl($request));
        }

        return [
            'page' => $pageInterface,
            'form' => $form->createView()
        ];
    }

    /**
     * @param Request $request
     * @param PageInterface $pageInterface
     *
     * @return RedirectResponse
     */
    protected function handleDelete(Request $request, PageInterface $pageInterface)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($pageInterface);
        $em->flush();

        return $this->redirect($this->getRedirectUrl($request));
    }
}