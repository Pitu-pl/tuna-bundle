<?php

namespace TheCodeine\NewsBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TheCodeine\NewsBundle\Entity\News;
use TheCodeine\TagBundle\Form\TagCollectionType;

class NewsType extends AbstractNewsType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('important', null, [
                'required' => false,
                'label' => 'ui.form.labels.featured'
            ])
            ->add('tags', TagCollectionType::class, [
                'required' => false,
                'label' => 'ui.form.labels.tags'
            ])
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'required' => false,
                'label' => 'ui.form.labels.create.date'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return News::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'thecodeine_newsbundle_news';
    }
}