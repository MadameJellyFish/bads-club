<?php

namespace App\Entity;

use App\Repository\SportCourtRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Entity(repositoryClass: SportCourtRepository::class)]
class SportCourt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $court_name = null;

    #[ORM\ManyToOne(inversedBy: 'sportCourts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sport $sport = null;

    /**
     * @var Collection<int, UserReservation>
     */
    #[ORM\OneToMany(targetEntity: UserReservation::class, mappedBy: 'court')]
    private Collection $userReservations;

    public function __construct()
    {
        $this->userReservations = new ArrayCollection();
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
        return $this->userReservations;
    }

    public function addUserReservation(UserReservation $userReservation): static
    {
        if (!$this->userReservations->contains($userReservation)) {
            $this->userReservations->add($userReservation);
            $userReservation->setCourt($this);
        }

        return $this;
    }

    public function removeUserReservation(UserReservation $userReservation): static
    {
        if ($this->userReservations->removeElement($userReservation)) {
            // set the owning side to null (unless already changed)
            if ($userReservation->getCourt() === $this) {
                $userReservation->setCourt(null);
            }
        }

        return $this;
    }
}
