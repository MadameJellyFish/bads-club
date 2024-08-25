<?php

namespace App\Entity;

use App\Repository\UserReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Table(name: '`users_reservations`')]
#[ORM\Entity(repositoryClass: UserReservationRepository::class)]
class UserReservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $reservation_date = null;

    #[ORM\ManyToOne(inversedBy: 'user_reservations')]
    #[ORM\JoinColumn(name: 'court_id', referencedColumnName: 'id',nullable: false)]
    private ?SportCourt $court = null;

    #[ORM\ManyToOne(inversedBy: 'user_reservations')]
    #[ORM\JoinColumn(name: 'status_id', referencedColumnName: 'id', nullable: false)]
    private ?ReservationStatus $status = null;

    #[ORM\ManyToOne(inversedBy: 'user_reservations')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservationDate(): ?\DateTime
    {
        return $this->reservation_date;
    }

    public function setReservationDate(\DateTime $reservation_date): static
    {
        $this->reservation_date = $reservation_date;

        return $this;
    }

    public function getCourt(): ?SportCourt
    {
        return $this->court;
    }

    public function setCourt(?SportCourt $court): static
    {
        $this->court = $court;

        return $this;
    }

    public function getStatus(): ?ReservationStatus
    {
        return $this->status;
    }

    public function setStatus(?ReservationStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
