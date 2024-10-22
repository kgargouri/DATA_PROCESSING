<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    )
    {
        
    }
    public function load(ObjectManager $manager): void
    {
        $user=new User();
        $user->setUsername('karim');
        $user->setPassword($this->hasher->hashPassword($user, 'karim'));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $admin=new User();
        $admin->setUsername('admin');
        $admin->setPassword($this->hasher->hashPassword($user, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $manager->flush();
    }
}
