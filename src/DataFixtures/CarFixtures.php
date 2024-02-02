<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create and persist sample cars
        for ($i=1; $i < 24 ; $i++) {  
            $this->createCar($manager, '20'.$i, $i, rand(1000,90000), $i, rand(0,1));
        } 

        $manager->flush();
    } 

    private function createCar(ObjectManager $manager, $model, $marque, $reference, $nbrPlace, $statut)
    {
        $car = new Car();
        $car->setModel($model); 
        $car->setMarqueId($marque);
        $car->setReference($reference);
        $car->setNbrPlace($nbrPlace);
        $car->setStatut($statut);

        $manager->persist($car);
    }
}
