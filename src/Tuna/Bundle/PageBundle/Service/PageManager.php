<?php

namespace TheCodeine\PageBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

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
     * @param string $locale
     * @return mixed
     */
    public function getTitlesMap($locale)
    {
        return $this->repository->getTitlesMap($locale);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->class;
    }
}