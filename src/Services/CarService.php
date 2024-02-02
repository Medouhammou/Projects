<?php

namespace App\Services;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;

/** 
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    getAllCars()
 * @method Car[]    getCarById(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarService 
{ 

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllCars(): array
    {
        $carRepository = $this->entityManager->getRepository(Car::class);
        $cars = $carRepository->findAll();

        return $cars;
    }
 
    public function getAllCarsDispo(): array
    {
        $carRepository = $this->entityManager->getRepository(Car::class);
        $cars = $carRepository->findBy(['statut' => 1]);

        return $cars;
    } 

    public function getCarById(int $id): ?Car
    {
        $carRepository = $this->entityManager->getRepository(Car::class);
        $car = $carRepository->find($id);

        return $car;
    }
}
