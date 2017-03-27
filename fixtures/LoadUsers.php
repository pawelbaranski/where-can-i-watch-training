<?php


namespace fixtures;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadUsers implements FixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $admin = $userManager->createUser();
        $admin
            ->setUsername('admin')
            ->setEmail('admin@example.com')
            ->setPlainPassword('test123')
            ->setRoles(['ROLE_ADMIN'])
            ->setEnabled(true);

        $userManager->updateUser($admin);
    }
}