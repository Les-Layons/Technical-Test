<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       //Création de 10.000 utilisateurs
        for ($i = 0; $i < 10000; $i++) {
            $user = new User();
            $user->setName('User n°' . $i);
            $user->setLastActionAt(new \DateTimeImmutable());
            $user->setLastActionBy(null);
            $manager->persist($user);
            $this->addReference('USER_' . $i, $user);
        }

        $manager->flush();
    }
}
