<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $model = null;

    #[ORM\Column]
    private ?int $marque_id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column]
    private ?int $nbr_place = null;

    #[ORM\Column]
    private ?int $statut = 1;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(int $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getMarqueId(): ?int
    {
        return $this->marque_id;
    }

    public function setMarqueId(int $marque_id): static
    {
        $this->marque_id = $marque_id;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getNbrPlace(): ?int
    {
        return $this->nbr_place;
    }

    public function setNbrPlace(int $nbr_place): static
    {
        $this->nbr_place = $nbr_place;

        return $this;
    }
     
    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(int $statut): static
    {
        $this->statut = $statut;

        return $this;
    }
}
