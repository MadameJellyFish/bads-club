<?php

namespace App\Entity;

use App\Repository\UserSportRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Table(name: '`users_sports`')]
#[ORM\Entity(repositoryClass: UserSportRepository::class)]
class UserSport
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'userSports')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private ?User $user = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'userSports')]
    private ?Sport $sport = null;

    #[ORM\Id]
    #[ORM\ManyToOne]
    private ?PracticeLevel $practiceLevel = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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

    public function getPracticeLevel(): ?PracticeLevel
    {
        return $this->practiceLevel;
    }

    public function setPracticeLevel(?PracticeLevel $practiceLevel): static
    {
        $this->practiceLevel = $practiceLevel;

        return $this;
    }
}
