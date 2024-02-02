<?php

namespace App\Controller;

use App\Services\ReservationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; 
use Symfony\Component\HttpFoundation\JsonResponse; 
use Symfony\Component\HttpFoundation\Request;

class ReservationController extends AbstractController
{
    private $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * @Route("/api/reservations", name="api_create_reservation", methods={"POST"})
     */
    public function createReservation(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate and process reservation creation
        $reservation = $this->reservationService->createReservation($data);

        return $this->json($reservation);
    }

    /**
     * @Route("/api/reservations/{id}", name="api_update_reservation", methods={"PUT"})
     */
    public function updateReservation(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate and process reservation update
        $reservation = $this->reservationService->updateReservation($id, $data);

        return $this->json($reservation);
    }

    /**
     * @Route("/api/reservations/{id}", name="api_cancel_reservation", methods={"DELETE"})
     */
    public function cancelReservation(int $id): JsonResponse
    {
        // Process reservation cancellation
        $this->reservationService->cancelReservation($id);

        return $this->json(['message' => 'Reservation canceled successfully']);
    } 

    /**
     * @Route("/api/users/{id}/reservations)", name="api_user_reservation", methods={"GET"})
     * Retourn all reservations of user 
     */
    public function getReservationUser(int $id): JsonResponse
    {
        // Get validation by user
        $reservations = $this->reservationService->getReservationByUserId($id);

        return $this->json($reservations);
    }

    
}
