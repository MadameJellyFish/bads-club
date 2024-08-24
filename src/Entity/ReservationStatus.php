<?php

namespace App\Entity;

use App\Repository\ReservationStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Entity(repositoryClass: ReservationStatusRepository::class)]
class ReservationStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $status_name = null;

    /**
     * @var Collection<int, UserReservation>
     */
    #[ORM\OneToMany(targetEntity: UserReservation::class, mappedBy: 'status')]
    private Collection $user_reservations;

    public function __construct()
    {
        $this->user_reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatusName(): ?string
    {
        return $this->status_name;
    }

    public function setStatusName(string $status_name): static
    {
        $this->status_name = $status_name;

        return $this;
    }

    /**
     * @return Collection<int, UserReservation>
     */
    public function getUserReservations(): Collection
    {
        return $this->user_reservations;
    }

    public function addUserReservation(UserReservation $userReservation): static
    {
        if (!$this->user_reservations->contains($userReservation)) {
            $this->user_reservations->add($userReservation);
            $userReservation->setStatus($this);
        }

        return $this;
    }

    public function removeUserReservation(UserReservation $userReservation): static
    {
        if ($this->user_reservations->removeElement($userReservation)) {
            // set the owning side to null (unless already changed)
            if ($userReservation->getStatus() === $this) {
                $userReservation->setStatus(null);
            }
        }

        return $this;
    }
}
