<?php

namespace TheCodeine\MenuBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use TheCodeine\MenuBundle\Entity\Menu;
use TunaCMS\PageComponent\Model\PageInterface;

class PageSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            'postUpdate'
        ];
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $page = $args->getEntity();

        if (!$page instanceof PageInterface) {
            return;
        }

        $em = $args->getEntityManager();
        $menus = $em->getRepository(Menu::class)->findBy([
            'page' => $page,
        ]);

        if (!count($menus)) {
            return;
        }

        foreach ($menus as $menu) {
            MenuListener::synchronizeWithPage($menu, $page);
        }

        $em->flush();
    }
}
