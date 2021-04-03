<?php

namespace App\DataFixtures;

use App\Entity\Continent;
use App\Entity\Pays;
use App\Entity\Region;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */

    public function load(ObjectManager $manager)
    {
        $asie = new Continent();
        $asie->setNom('Asie');
        $manager->persist($asie);

        $japon = new Pays();
        $japon->setNom("Japon");
        $japon->setContinent($asie);
        $manager->persist($japon);

        $tokyo = new Region();
        $tokyo->setNom("Tokyo");
        $tokyo->setPays($japon);
        $manager->persist($tokyo);

        $kyoto = new Region();
        $kyoto->setNom("Kyoto");
        $kyoto->setPays($japon);
        $manager->persist($kyoto);

        $america = new Continent();
        $america->setNom("Amerique");
        $manager->persist($america);

        $usa = new Pays();
        $usa->setNom("USA");
        $usa->setContinent($america);
        $manager->persist($usa);

        $texas = new Region();
        $texas->setNom("Texas");
        $texas->setPays($usa);
        $manager->persist($texas);

        $wash = new Region();
        $wash->setNom("Washington");
        $wash->setPays($usa);
        $manager->persist($wash);

        $europe = new Continent();
        $europe->setNom("Europe");
        $manager->persist($europe);

        $france = new Pays();
        $france->setNom("France");
        $france->setContinent($europe);
        $manager->persist($france);

        $normandie = new Region();
        $normandie->setNom("Normandie");
        $normandie->setPays($france);
        $manager->persist($normandie);

        $bretagne = new Region();
        $bretagne->setNom("Bretagne");
        $bretagne->setPays($france);
        $manager->persist($bretagne);

        $manager->flush();
    }
}
