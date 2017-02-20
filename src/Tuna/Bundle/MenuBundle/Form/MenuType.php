<?php

namespace TheCodeine\MenuBundle\Form;

use A2lix\TranslationFormBundle\Form\Type\GedmoTranslationsType;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TheCodeine\MenuBundle\Entity\Menu;
use TunaCMS\PageComponent\Model\Page;

class MenuType extends AbstractType implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $nodeId = $builder->getData()->getId();

        $builder
            ->add('clickable', CheckboxType::class, [
                'label' => 'ui.form.labels.clickable'
            ])
            ->add('published', CheckboxType::class, [
                'label' => 'ui.form.labels.published'
            ])
            ->add('page', EntityType::class, [
                'class' => $this->container->getParameter('the_codeine_page.model'),
                'property' => 'title',
                'empty_value' => 'ui.form.labels.not_linked',
                'attr' => ['class' => 'filtered'],
                'label' => 'ui.form.labels.page'
            ])
            ->add('path', TextType::class, [
                'label' => 'ui.form.labels.path'
            ])
            ->add('translations', GedmoTranslationsType::class, [
                'translatable_class' => Menu::class,
                'fields' => [
                    'label' => [
                        'label' => 'ui.form.labels.label'
                    ],
                    'externalUrl' => [
                        'label' => 'ui.form.labels.external'
                    ]
                ]
            ])
            ->add('parent', null, [
                'query_builder' => function (EntityRepository $er) use ($nodeId) {
                    return $this->queryParentElement($er, $nodeId);
                },
                'label' => 'ui.form.labels.parent',
                'property' => 'indentedName',
                'required' => true,
            ]);
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
            'translation_domain' => 'tuna_admin',
        ]);
    }

    /**
     * @param EntityRepository $er
     * @param int $nodeId
     *
     * @return QueryBuilder
     */
    protected function queryParentElement(EntityRepository $er, $nodeId = null)
    {
        $qb = $er->createQueryBuilder('p')
            ->orderBy('p.root', 'ASC')
            ->addOrderBy('p.lft', 'ASC');

        if ($nodeId !== null) {
            $qb
                ->where('p.id != :nodeId')
                ->setParameter('nodeId', $nodeId);
        }

        return $qb;
    }
}