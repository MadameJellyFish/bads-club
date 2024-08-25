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

    #[ORM\Column(length: 50, unique: true)]
    private ?string $sport_name = null;

    /**
     * @var Collection<int, SportCourt>
     */
    #[ORM\OneToMany(targetEntity: SportCourt::class, mappedBy: 'sport', orphanRemoval: true)]
    private Collection $sport_courts;

    /**
     * @var Collection<int, UserSport>
     */
    #[ORM\OneToMany(targetEntity: UserSport::class, mappedBy: 'sport')]
    private Collection $user_sports;

    public function __construct()
    {
        $this->sport_courts = new ArrayCollection();
        $this->user_sports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getsportName(): ?string
    {
        return $this->sport_name;
    }

    public function setsportName(string $sport_name): static
    {
        $this->sport_name = $sport_name;

        return $this;
    }

    /**
     * @return Collection<int, SportCourt>
     */
    public function getSportCourts(): Collection
    {
        return $this->sport_courts;
    }

    public function addSportCourt(SportCourt $sportCourt): static
    {
        if (!$this->sport_courts->contains($sportCourt)) {
            $this->sport_courts->add($sportCourt);
            $sportCourt->setSport($this);
        }

        return $this;
    }

    public function removeSportCourt(SportCourt $sportCourt): static
    {
        if ($this->sport_courts->removeElement($sportCourt)) {
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
        return $this->user_sports;
    }

    public function addUserSport(UserSport $userSport): static
    {
        if (!$this->user_sports->contains($userSport)) {
            $this->user_sports->add($userSport);
            $userSport->setSport($this);
        }

        return $this;
    }

    public function removeUserSport(UserSport $userSport): static
    {
        if ($this->user_sports->removeElement($userSport)) {
            // set the owning side to null (unless already changed)
            if ($userSport->getSport() === $this) {
                $userSport->setSport(null);
            }
        }

        return $this;
    }
}
