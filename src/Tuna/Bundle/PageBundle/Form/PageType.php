<?php

namespace TheCodeine\PageBundle\Form;

use A2lix\TranslationFormBundle\Form\Type\GedmoTranslationsType;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TunaCMS\EditorBundle\Form\EditorType;

class PageType extends AbstractType implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var bool
     */
    private $validate;

    /**
     * PageType constructor.
     *
     * @param $validate
     */
    public function __construct($validate = false)
    {
        $this->validate = $validate;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$this->validate) {
            $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                $event->stopPropagation();
            }, 900);
        }

        $builder
            ->add('published', CheckboxType::class, [
                'required' => false,
                'label' => 'ui.form.labels.published'
            ])
            ->add('translations', GedmoTranslationsType::class, [
                'translatable_class' => $this->container->getParameter('the_codeine_page.model'),
                'fields' => [
                    'title' => [
                        'required' => true,
                        'label' => 'ui.form.labels.title'
                    ],
                    'teaser' => [
                        'field_type' => EditorType::class,
                        'config_name' => 'tuna.editor.config.simple',
                        'attr' => [
                            'data-type' => 'basic'
                        ],
                        'required' => false,
                        'label' => 'ui.form.labels.teaser'
                    ],
                    'body' => [
                        'field_type' => EditorType::class,
                        'required' => true,
                        'label' => 'ui.form.labels.body'
                    ],
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->container->getParameter('the_codeine_page.model'),
            'translation_domain' => 'tuna_admin',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'thecodeine_pagebundle_page';
    }
}