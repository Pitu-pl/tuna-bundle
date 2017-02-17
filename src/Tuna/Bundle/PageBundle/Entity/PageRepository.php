<?php

namespace TheCodeine\PageBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Gedmo\Translatable\TranslatableListener;
use TunaCMS\PageComponent\Model\PageInterface;

class PageRepository extends EntityRepository
{
    public function findAllPublished()
    {
        return $this->findBy(['published' => true]);
    }

    public function getListQuery($published = null)
    {
        $query = $this->createQueryBuilder('p');

        if ($published !== null) {
            $query->andWhere('p.published = 1');
        }

        return $query->getQuery();
    }

    public function getSingleItem($slug)
    {
        $qb = $this->createQueryBuilder('n')
            ->andWhere('n.slug = :slug')
            ->setParameter('slug', $slug)
            ->setMaxResults(1);

        return $this->addTranslationWalker($qb)->getResult();
    }

    public function getTitlesMap($defaultLocale)
    {
        $result = $this->_em->createQueryBuilder()
            ->select('p.id, p.title originalTitle, t.content title, t.locale')
            ->from(PageInterface::class, 'p')
            ->leftJoin('p.translations', 't', Query\Expr\Join::WITH, 't.field = \'title\'')
            ->getQuery()->getArrayResult();

        $map = [];
        foreach ($result as $item) {
            if (!array_key_exists($item['id'], $map)) {
                $map[$item['id']] = [
                    $defaultLocale => $item['originalTitle'],
                ];
            }

            if ($item['locale'] !== null) {
                $map[$item['id']][$item['locale']] = $item['title'];
            }
        }

        return $map;
    }

    protected function addTranslationWalker(QueryBuilder $qb)
    {
        return $qb
            ->getQuery()
            ->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
            ->setHint(TranslatableListener::HINT_INNER_JOIN, true);
    }
}
