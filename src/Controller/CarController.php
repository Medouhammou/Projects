<?php

namespace App\Controller;

use App\Services\CarService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse; 

class CarController extends AbstractController
{ 
    private $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    /**
     * @Route("/api/cars", name="api_cars", methods={"GET"})
     * Retourn all cars diponible 
     */
    public function getCars(): JsonResponse
    {
        $cars = $this->carService->getAllCarsDispo();
        return $this->json($cars);
    }

    /**
     * @Route("/api/cars/{id}", name="api_car_details", methods={"GET"})
     */
    public function getCarDetails(int $id): JsonResponse
    {
        $car = $this->carService->getCarById($id);

        if (!$car) {
            return $this->json(['error' => 'Car not found'], 404);
        }

        return $this->json($car);
    }
}
