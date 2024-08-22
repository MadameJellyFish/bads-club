<?php

namespace App\Entity;

use App\Repository\PracticeLevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Entity(repositoryClass: PracticeLevelRepository::class)]
class PracticeLevel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $level_name = null;

    /**
     * @var Collection<int, UserSport>
     */
    #[ORM\OneToMany(targetEntity: UserSport::class, mappedBy: 'practice_level')]
    private Collection $userSports;

    public function __construct()
    {
        $this->userSports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevelName(): ?string
    {
        return $this->level_name;
    }

    public function setLevelName(string $level_name): static
    {
        $this->level_name = $level_name;

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
            $userSport->setPracticeLevel($this);
        }

        return $this;
    }

    public function removeUserSport(UserSport $userSport): static
    {
        if ($this->userSports->removeElement($userSport)) {
            // set the owning side to null (unless already changed)
            if ($userSport->getPracticeLevel() === $this) {
                $userSport->setPracticeLevel(null);
            }
        }

        return $this;
    }
}
