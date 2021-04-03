<?php

namespace App\DataFixtures;

use App\Entity\Continents;
use App\Entity\Country;
use App\Entity\Regions;
use App\Repository\ContinentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\String_;
class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */

    public function load(ObjectManager $manager)
    {
        $asie = new Continents();
        $asie->setNom("Asie");
        $manager->persist($asie);

        $japon = new Country();
        $japon->setNom("Japon");
        $japon->setContinents($asie);
        $manager->persist($japon);

        $tokyo = new Regions();
        $tokyo->setNom("Tokyo");
        $tokyo->setCountry($japon);
        $manager->persist($tokyo);

        $kyoto = new Regions();
        $kyoto->setNom("Kyoto");
        $kyoto->setCountry($japon);
        $manager->persist($kyoto);

        $america = new Continents();
        $america->setNom("Amerique");
        $manager->persist($america);

        $usa = new Country();
        $usa->setNom("USA");
        $usa->setContinents($america);
        $manager->persist($usa);

        $texas = new Regions();
        $texas->setNom("Texas");
        $texas->setCountry($usa);
        $manager->persist($texas);

        $wash = new Regions();
        $wash->setNom("Washington");
        $wash->setCountry($usa);
        $manager->persist($wash);

        $europe = new Continents();
        $europe->setNom("Europe");
        $manager->persist($europe);

        $france = new Country();
        $france->setNom("France");
        $france->setContinents($europe);
        $manager->persist($france);

        $normandie = new Regions();
        $normandie->setNom("Normandie");
        $normandie->setCountry($france);
        $manager->persist($normandie);

        $bretagne = new Regions();
        $bretagne->setNom("Bretagne");
        $bretagne->setCountry($france);
        $manager->persist($bretagne);




        $manager->flush();
    }
}
