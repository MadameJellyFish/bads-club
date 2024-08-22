<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
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
    private Collection $sportCourts;

    public function __construct()
    {
        $this->sportCourts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSportName(): ?string
    {
        return $this->sport_name;
    }

    public function setSportName(string $sport_name): static
    {
        $this->sport_name = $sport_name;

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
}
