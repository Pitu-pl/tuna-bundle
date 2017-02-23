<?php

namespace TheCodeine\PageBundle\EventListener\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Mapping\RuntimeReflectionService;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class ORMMappedSuperClassSubscriber implements EventSubscriber
{
    const PAGE_MAPPED_ENTITY = 'TheCodeine\PageBundle\Entity\Page';

    /**
     * @var string
     */
    private $modelClass;

    /**
     * @var RuntimeReflectionService
     */
    private $reflectionService;

    /**
     * @param string $modelClass
     */
    public function __construct($modelClass)
    {
        $this->modelClass = $modelClass;
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
        $metadata = $eventArgs->getClassMetadata();

        if ($metadata->rootEntityName !== self::PAGE_MAPPED_ENTITY) {
            return;
        }

        if ($this->modelClass === self::PAGE_MAPPED_ENTITY && $metadata->getName() === self::PAGE_MAPPED_ENTITY) {
            // We use basic entity
            $metadata->isMappedSuperclass = false;

            $this->setAssociationMappings($metadata, $eventArgs->getEntityManager()->getConfiguration());

            return;
        } elseif ($this->modelClass !== self::PAGE_MAPPED_ENTITY && $metadata->getName() === self::PAGE_MAPPED_ENTITY) {
            // We overwrite basic entity
            $this->unsetAssociationMappings($metadata);

            return;
        }
    }

    /**
     * @param ClassMetadataInfo $metadata
     * @param $configuration
     */
    private function setAssociationMappings(ClassMetadataInfo $metadata, $configuration)
    {
        foreach (class_parents($metadata->getName()) as $parent) {
            if (false === in_array($parent, $configuration->getMetadataDriverImpl()->getAllClassNames())) {
                continue;
            }

            $parentMetadata = new ClassMetadata($parent, $configuration->getNamingStrategy());

            // Wakeup Reflection
            $parentMetadata->wakeupReflection($this->getReflectionService());

            // Load Metadata
            $configuration->getMetadataDriverImpl()->loadMetadataForClass($parent, $parentMetadata);

            if ($metadata->rootEntityName !== self::PAGE_MAPPED_ENTITY) {
                continue;
            }

            if ($parentMetadata->isMappedSuperclass) {
                foreach ($parentMetadata->getAssociationMappings() as $key => $value) {
                    if ($this->isRelation($value['type']) && !isset($metadata->associationMappings[$key])) {
                        $metadata->associationMappings[$key] = $value;
                    }
                }
            }
        }
    }

    /**
     * @param ClassMetadataInfo $metadata
     */
    private function unsetAssociationMappings(ClassMetadataInfo $metadata)
    {
        foreach ($metadata->getAssociationMappings() as $key => $value) {
            if ($this->isRelation($value['type'])) {
                unset($metadata->associationMappings[$key]);
            }
        }
    }

    /**
     * @return RuntimeReflectionService
     */
    protected function getReflectionService()
    {
        if ($this->reflectionService === null) {
            $this->reflectionService = new RuntimeReflectionService();
        }
        return $this->reflectionService;
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    private function isRelation($type)
    {
        return in_array(
            $type,
            [
                ClassMetadataInfo::MANY_TO_MANY,
                ClassMetadataInfo::ONE_TO_MANY,
                ClassMetadataInfo::ONE_TO_ONE,
            ],
            true
        );
    }
}