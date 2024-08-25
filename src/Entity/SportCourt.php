<?php

namespace App\Entity;

use App\Repository\SportCourtRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Table(name: '`sports_courts`')]
#[ORM\Entity(repositoryClass: SportCourtRepository::class)]
class SportCourt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $court_name = null;

    #[ORM\ManyToOne(inversedBy: 'sport_courts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sport $sport = null;

    /**
     * @var Collection<int, UserReservation>
     */
    #[ORM\OneToMany(targetEntity: UserReservation::class, mappedBy: 'court')]
    private Collection $user_reservations;

    public function __construct()
    {
        $this->user_reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourtName(): ?string
    {
        return $this->court_name;
    }

    public function setCourtName(string $court_name): static
    {
        $this->court_name = $court_name;

        return $this;
    }

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): static
    {
        $this->sport = $sport;

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
            $userReservation->setCourt($this);
        }

        return $this;
    }

    public function removeUserReservation(UserReservation $userReservation): static
    {
        if ($this->user_reservations->removeElement($userReservation)) {
            // set the owning side to null (unless already changed)
            if ($userReservation->getCourt() === $this) {
                $userReservation->setCourt(null);
            }
        }

        return $this;
    }
}
