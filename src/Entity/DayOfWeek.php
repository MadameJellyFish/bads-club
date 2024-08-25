<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Entity\SportCourtAvailability;
use App\Repository\DayOfWeekRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ApiResource]
#[ORM\Table(name: '`days_of_week`')]
#[ORM\Entity(repositoryClass: DayOfWeekRepository::class)]
class DayOfWeek
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $dayName = null;

    /**
     * @var Collection<int, SportCourtAvailability>
     */
    #[ORM\OneToMany(targetEntity: SportCourtAvailability::class, mappedBy: 'dayOfWeek')]
    private Collection $sportCourtAvailabilities;

    /**
     * @var Collection<int, UserAvailability>
     */
    #[ORM\OneToMany(targetEntity: UserAvailability::class, mappedBy: 'dayOfWeek')]
    private Collection $userAvailabilities;

    public function __construct()
    {
        $this->sportCourtAvailabilities = new ArrayCollection();
        $this->userAvailabilities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDayName(): ?string
    {
        return $this->dayName;
    }

    public function setDayName(string $dayName): static
    {
        $this->dayName = $dayName;

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
            $sportCourtAvailability->setDayOfWeek($this);
        }

        return $this;
    }

    public function removeSportCourtAvailability(SportCourtAvailability $sportCourtAvailability): static
    {
        if ($this->sportCourtAvailabilities->removeElement($sportCourtAvailability)) {
            // set the owning side to null (unless already changed)
            if ($sportCourtAvailability->getDayOfWeek() === $this) {
                $sportCourtAvailability->setDayOfWeek(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserAvailability>
     */
    public function getUserAvailabilities(): Collection
    {
        return $this->userAvailabilities;
    }

    public function addUserAvailability(UserAvailability $userAvailability): static
    {
        if (!$this->userAvailabilities->contains($userAvailability)) {
            $this->userAvailabilities->add($userAvailability);
            $userAvailability->setDayOfWeek($this);
        }

        return $this;
    }

    public function removeUserAvailability(UserAvailability $userAvailability): static
    {
        if ($this->userAvailabilities->removeElement($userAvailability)) {
            // set the owning side to null (unless already changed)
            if ($userAvailability->getDayOfWeek() === $this) {
                $userAvailability->setDayOfWeek(null);
            }
        }

        return $this;
    }
}
