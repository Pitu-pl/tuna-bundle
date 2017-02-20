<?php

namespace TheCodeine\PageBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class MenuManager
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
     * @param array $order
     */
    public function saveOrder(array $order)
    {
        $nodes = [];
        $entities = $this->repository->findAll();

        foreach ($entities as $entity) {
            $nodes[$entity->getId()] = $entity;
        }

        foreach ($order as $nodeTreeData) {
            $nodes[(int)$nodeTreeData['id']]->setTreeData(
                (int)$nodeTreeData['left'],
                (int)$nodeTreeData['right'],
                (int)$nodeTreeData['depth'],
                isset($nodes[$nodeTreeData['parent_id']]) ? $nodes[$nodeTreeData['parent_id']] : null
            );
        }

        $this->entityManager->flush();
    }

    /**
     * @param null $name
     * @param bool $filterUnpublished
     * @return mixed
     */
    public function getMenuTree($name = null, $filterUnpublished = true)
    {
        return $this->repository->getMenuTree($name, $filterUnpublished);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->class;
    }
}