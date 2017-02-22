<?php

namespace TheCodeine\PageBundle\EventListener\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\Mapping\RuntimeReflectionService;
use TunaCMS\CommonComponent\Metadata\RegistryInterface;
use TunaCMS\PageComponent\Model\PageInterface;

abstract class AbstractDoctrineSubscriber implements EventSubscriber
{
    /**
     * @var RegistryInterface
     */
    protected $resourceRegistry;

    /**
     * @var RuntimeReflectionService
     */
    private $reflectionService;

    /**
     * @param RegistryInterface $resourceRegistry
     */
    public function __construct(RegistryInterface $resourceRegistry)
    {
        $this->resourceRegistry = $resourceRegistry;
    }

    /**
     * @param ClassMetadata $metadata
     *
     * @return bool
     */
    protected function isResource(ClassMetadata $metadata)
    {
        if (!$reflClass = $metadata->getReflectionClass()) {
            return false;
        }

        return $reflClass->implementsInterface(PageInterface::class);
    }

    protected function getReflectionService()
    {
        if ($this->reflectionService === null) {
            $this->reflectionService = new RuntimeReflectionService();
        }

        return $this->reflectionService;
    }
}