<?php

namespace App\DataFixtures;

use App\Entity\Offer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OfferFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //Création de 10.000 offres uniquement pour le user n°1
        for ($i = 0; $i < 10000; $i++) {
            $offer = new Offer();
            $offer->addUser($this->getReference('USER_1'));
            $offer->setTitle('Offre n°' . $i);
            $manager->persist($offer);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            'App\DataFixtures\UserFixtures'
        ];
    }
}
