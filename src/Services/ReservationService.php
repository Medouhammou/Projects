<?php

namespace App\Services;

use App\Entity\Car;
use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;  
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * @extends ServiceEntityRepository<Reservation>
 *
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationService extends ServiceEntityRepository
{
    private $entityManager;
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function createReservation(array $data): Reservation
    { 
        // Validate the input data
        $this->validateReservationData($data);
        // You might want to perform checks for date validity, car availability, etc.

        $reservation = new Reservation();
        $reservation->setDateDebut(new \DateTime($data['date_debut']));
        $reservation->setDateRetour(new \DateTime($data['date_fin'])); 
        $reservation->setCarId($data['car_id']); 
        $reservation->setUserId($data['user_id']);  

        $this->entityManager->persist($reservation);
        $this->entityManager->flush();

        return $reservation;
    }

    public function updateReservation(int $id, array $data): Reservation
    {
        // Implement logic to validate and update an existing reservation

        $reservation = $this->entityManager->getRepository(Reservation::class)->find($id);

        if (!$reservation) {
            // Handle reservation not found error$
            $errors = ["the reservation not found"];
            throw new ValidatorException(json_encode($errors));
        }

        $reservation->setDateDebut(new \DateTime($data['date_debut']));
        $reservation->setDateRetour(new \DateTime($data['date_fin'])); 
        $reservation->setCarId($data['car_id']); 
        $reservation->setUserId($data['user_id']);  

        // Make the car indesponible
        $car = $this->entityManager->getRepository(Car::class)->find($data['car_id']);
        $car->setStatut(0);
        $this->entityManager->flush();


        return $reservation;
    }

    
    public function getReservationByUserId(int $userId): array
    {
        $reservationRepository = $this->entityManager->getRepository(Reservation::class);
        $reservations = $reservationRepository->findBy(['user_id' => $userId]);

        return $reservations;
    } 

    private function validateReservationData(array $data): void
    {
        $reservation = new Reservation();
        $reservation->setDateDebut(new \DateTime($data['date_debut']));
        $reservation->setDateRetour(new \DateTime($data['date_fin'])); 
        $reservation->setCarId($data['car_id']); 
        $reservation->setUserId($data['user_id']);  

        $violations = $this->validator->validate($reservation);

        if ($violations->count() > 0) {
            // Handle validation errors 
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()][] = $violation->getMessage();
            }

            // Throw a validation exception with the errors
            throw new ValidatorException(json_encode($errors));
        }
    }

    public function cancelReservation(int $id): void
    {
        // Implement logic to cancel an existing reservation

        $reservation = $this->entityManager->getRepository(Reservation::class)->find($id);

        if ($reservation) {
            $this->entityManager->remove($reservation);

            // Make the car disponible
            $car = $this->entityManager->getRepository(Car::class)->find($reservation->car_id);
            $car->setStatut(1);

            $this->entityManager->flush();
        }
    }
}
