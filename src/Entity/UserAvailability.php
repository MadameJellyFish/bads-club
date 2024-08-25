<?php

namespace App\Entity;

use App\Entity\DayOfWeek;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserAvailabilityRepository;

#[ApiResource]
#[ORM\Entity(repositoryClass: UserAvailabilityRepository::class)]
class UserAvailability
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'user_availability_start_time',type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $userAvailabilityStartTime = null;

    #[ORM\Column(name: 'user_availability_end_time',type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $userAvailabilityEndTime = null;

    #[ORM\ManyToOne(inversedBy: 'userAvailabilities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $relatedUser = null;

    #[ORM\ManyToOne(inversedBy: 'userAvailabilities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DayOfWeek $dayOfWeek = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserAvailabilityStartTime(): ?\DateTimeInterface
    {
        return $this->userAvailabilityStartTime;
    }

    public function setUserAvailabilityStartTime(\DateTimeInterface $userAvailabilityStartTime): static
    {
        $this->userAvailabilityStartTime = $userAvailabilityStartTime;

        return $this;
    }

    public function getUserAvailabilityEndTime(): ?\DateTimeInterface
    {
        return $this->userAvailabilityEndTime;
    }

    public function setUserAvailabilityEndTime(\DateTimeInterface $userAvailabilityEndTime): static
    {
        $this->userAvailabilityEndTime = $userAvailabilityEndTime;

        return $this;
    }

    public function getRelatedUser(): ?User
    {
        return $this->relatedUser;
    }

    public function setRelatedUser(?User $relatedUser): static
    {
        $this->relatedUser = $relatedUser;

        return $this;
    }

    public function getDayOfWeek(): ?DayOfWeek
    {
        return $this->dayOfWeek;
    }

    public function setDayOfWeek(?DayOfWeek $dayOfWeek): static
    {
        $this->dayOfWeek = $dayOfWeek;

        return $this;
    }
}
