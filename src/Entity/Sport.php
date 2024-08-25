<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Table(name: '`sports`')]
#[ORM\Entity(repositoryClass: SportRepository::class)]
class Sport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: "sport_name", length: 50, unique: true)]
    private ?string $sportName = null;

    /**
     * @var Collection<int, SportCourt>
     */
    #[ORM\OneToMany(targetEntity: SportCourt::class, mappedBy: 'sport', orphanRemoval: true)]
    private Collection $sportCourts;

    /**
     * @var Collection<int, UserSport>
     */
    #[ORM\OneToMany(targetEntity: UserSport::class, mappedBy: 'sport')]
    private Collection $userSports;

    public function __construct()
    {
        $this->sportCourts = new ArrayCollection();
        $this->userSports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getsportName(): ?string
    {
        return $this->sportName;
    }

    public function setsportName(string $sportName): static
    {
        $this->sportName = $sportName;

        return $this;
    }

    /**
     * @return Collection<int, SportCourt>
     */
    public function getSportCourts(): Collection
    {
        return $this->sportCourts;
    }

    public function addSportCourt(SportCourt $sportCourt): static
    {
        if (!$this->sportCourts->contains($sportCourt)) {
            $this->sportCourts->add($sportCourt);
            $sportCourt->setSport($this);
        }

        return $this;
    }

    public function removeSportCourt(SportCourt $sportCourt): static
    {
        if ($this->sportCourts->removeElement($sportCourt)) {
            // set the owning side to null (unless already changed)
            if ($sportCourt->getSport() === $this) {
                $sportCourt->setSport(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserSport>
     */
    public function getUserSports(): Collection
    {
        return $this->userSports;
    }

    public function addUserSport(UserSport $userSport): static
    {
        if (!$this->userSports->contains($userSport)) {
            $this->userSports->add($userSport);
            $userSport->setSport($this);
        }

        return $this;
    }

    public function removeUserSport(UserSport $userSport): static
    {
        if ($this->userSports->removeElement($userSport)) {
            // set the owning side to null (unless already changed)
            if ($userSport->getSport() === $this) {
                $userSport->setSport(null);
            }
        }

        return $this;
    }
}
