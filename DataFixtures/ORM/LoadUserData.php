<?php

namespace TheCodeine\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use FOS\UserBundle\Entity\UserManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    protected static $USERS = [
        [
            'email' => 'fake@thecodeine.com',
            'name' => 'admin',
            'role' => 'ROLE_ADMIN',
        ],
        [
            'email' => 'fakesuperadmin@thecodeine.com',
            'name' => 'superadmin',
            'role' => 'ROLE_SUPER_ADMIN',
        ],
    ];

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $om)
    {
        /* @var UserManager $userManager */
        $userManager = $this->container->get('fos_user.user_manager');
        foreach ($this->getUsers() as $u) {
            if ($userManager->findUserByUsername($u['name']) != null || $userManager->findUserByEmail($u['email']) != null) {
                continue;
            }

            $user = $userManager->createUser();
            $user->setEnabled(true);
            $user->setPlainPassword($u['name']);
            $user->setUsername($u['name']);
            $user->setEmail($u['email']);
            $user->addRole($u['role']);

            $userManager->updateUser($user);
        }
    }

    public function getOrder()
    {
        return 1;
    }

    protected function getUsers()
    {
        return self::$USERS;
    }
}