<?php

namespace TheCodeine\PageBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class PageManager
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct($class, EntityManager $entityManager)
    {
        $this->class = $class;
        $this->entityManager = $entityManager;

        $this->repository = $this->entityManager->getRepository($this->class);
    }

    /**
     * @param int $id
     *
     * @return null|object
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param string $locale
     *
     * @return array
     */
    public function getTitlesMap($locale)
    {
        return $this->repository->getTitlesMap($locale, $this->class);
    }

    /**
     * @param bool $onlyPublished
     *
     * @return Query
     */
    public function getListQuery($onlyPublished = false)
    {
        return $this->repository->getListQuery($onlyPublished);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->class;
    }
}