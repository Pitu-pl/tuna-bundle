<?php

namespace TheCodeine\PageBundle\Form;

use AppBundle\Entity\Page;
use Symfony\Component\Form\FormBuilderInterface;

class PageType extends AbstractPageType
{
    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return Page::class;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }
}