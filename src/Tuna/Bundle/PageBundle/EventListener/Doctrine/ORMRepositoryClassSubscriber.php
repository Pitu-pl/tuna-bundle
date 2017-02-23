<?php

namespace TheCodeine\PageBundle\EventListener\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * @author Ben Davies <ben.davies@gmail.com>
 */
final class ORMRepositoryClassSubscriber implements EventSubscriber
{
    const PAGE_MAPPED_ENTITY = 'TheCodeine\PageBundle\Entity\Page';

    /**
     * @var string
     */
    private $modelClass;

    /**
     * @var string
     */
    private $repositoryClass;

    /**
     * @param string $modelClass
     * @param string $repositoryClass
     */
    public function __construct($modelClass, $repositoryClass)
    {
        $this->modelClass = $modelClass;
        $this->repositoryClass = $repositoryClass;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $this->setCustomRepositoryClass($eventArgs->getClassMetadata());
    }

    /**
     * @param ClassMetadata $metadata
     */
    private function setCustomRepositoryClass(ClassMetadata $metadata)
    {
        if ($metadata->rootEntityName !== self::PAGE_MAPPED_ENTITY || $metadata->getName() !== self::PAGE_MAPPED_ENTITY) {
            return;
        }

        $metadata->setCustomRepositoryClass($this->repositoryClass);
    }
}