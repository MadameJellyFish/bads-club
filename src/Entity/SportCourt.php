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

    #[ORM\Column(name: "court_name", length: 50)]
    private ?string $courtName = null;

    #[ORM\ManyToOne(inversedBy: 'sportCourts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sport $sport = null;

    /**
     * @var Collection<int, UserReservation>
     */
    #[ORM\OneToMany(targetEntity: UserReservation::class, mappedBy: 'sportCourt')]
    private Collection $userReservations;

    /**
     * @var Collection<int, SportCourtAvailability>
     */
    #[ORM\OneToMany(targetEntity: SportCourtAvailability::class, mappedBy: 'sportCourt')]
    private Collection $sportCourtAvailabilities;

    public function __construct()
    {
        $this->userReservations = new ArrayCollection();
        $this->sportCourtAvailabilities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourtName(): ?string
    {
        return $this->courtName;
    }

    public function setCourtName(string $courtName): static
    {
        $this->courtName = $courtName;

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

    /**
     * @return Collection<int, SportCourtAvailability>
     */
    public function getSportCourtAvailabilities(): Collection
    {
        return $this->sportCourtAvailabilities;
    }

    public function addSportCourtAvailability(SportCourtAvailability $sportCourtAvailability): static
    {
        if (!$this->sportCourtAvailabilities->contains($sportCourtAvailability)) {
            $this->sportCourtAvailabilities->add($sportCourtAvailability);
            $sportCourtAvailability->setSportCourt($this);
        }

        return $this;
    }

    public function removeSportCourtAvailability(SportCourtAvailability $sportCourtAvailability): static
    {
        if ($this->sportCourtAvailabilities->removeElement($sportCourtAvailability)) {
            // set the owning side to null (unless already changed)
            if ($sportCourtAvailability->getSportCourt() === $this) {
                $sportCourtAvailability->setSportCourt(null);
            }
        }

        return $this;
    }
}
