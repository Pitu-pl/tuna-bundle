<?php

namespace TheCodeine\PageBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use TunaCMS\PageComponent\Model\PageInterface;

class PageAliasListener
{
    public function postPersist(PageInterface $pageInterface, LifecycleEventArgs $event)
    {
        if (null === $pageInterface->getAlias()) {
            $pageInterface->setAlias($pageInterface->getSlug());

            $em = $event->getEntityManager();

            $em->persist($pageInterface);
            $em->flush();
        }
    }
}
