<?php

namespace App\Entity;

use App\Repository\PracticeLevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Table(name: '`practice_levels`')]
#[ORM\Entity(repositoryClass: PracticeLevelRepository::class)]
class PracticeLevel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $levelName = null;

    /**
     * @var Collection<int, UserSport>
     */
    #[ORM\OneToMany(targetEntity: UserSport::class, mappedBy: 'practiceLevel')]
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
        return $this->levelName;
    }

    public function setLevelName(string $levelName): static
    {
        $this->levelName = $levelName;

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
