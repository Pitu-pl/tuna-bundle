<?php

namespace TheCodeine\NewsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use TheCodeine\NewsBundle\Entity\News;
use TheCodeine\PageBundle\Entity\PageRepository;

/**
 * NewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NewsRepository extends PageRepository
{
    public function getListQuery($type = null)
    {
        $type = ucfirst(strtolower($type));
        $qb = $this->createQueryBuilder('n');
        if ($type) {
            $qb->where('n INSTANCE OF TheCodeineNewsBundle:' . $type);
        }

        return $qb->getQuery();
    }

    public function getItemsForTag($tag)
    {
        if (!$tag) {
            return false;
        }

        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.tags', 'tag')
            ->where('p.published=1')
            ->orderBy('p.createdAt', 'DESC');

        if (is_string($tag)) {
            $qb->andWhere('tag.name = :tag')
                ->setParameter('tag', $tag);
        } else {
            $qb->andWhere('tag = :tag')
                ->setParameter('tag', $tag);
        }

        return $this->addTranslationWalker($qb);
    }

    public function getSimilar($limit = 2, BaseNews $news)
    {
        $tagNames = array();
        foreach ($news->getTags() as $tag) {
            $tagNames[] = $tag->getName();
        }

        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.tags', 'tag')
            ->where('p.published=1')
            ->andWhere('p.id != :article_id')
            ->setParameter('article_id', $news->getId())
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($limit);

        if (count($tagNames) > 0) {
            $qb->andWhere($qb->expr()->in('tag.name', $tagNames));
        }

        return $this->addTranslationWalker($qb)->getResult();
    }

    public function getLatestItems($limit = 3)
    {
        $qb = $this->createQueryBuilder('t')
            ->where('t.published=1')
            ->orderBy('t.createdAt', 'DESC')
            ->setMaxResults($limit);

        return $this->addTranslationWalker($qb)->getResult();
    }
}
