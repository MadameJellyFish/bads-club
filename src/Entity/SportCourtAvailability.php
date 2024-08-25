<?php

namespace App\Entity;

use App\Repository\SportCourtAvailabilityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Entity(repositoryClass: SportCourtAvailabilityRepository::class)]
class SportCourtAvailability
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'court_availability_start_time', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $courtAvailabilityStartTime = null;

    #[ORM\Column(name: 'court_availability_end_time', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $courtAvailabilityEndTime = null;

    #[ORM\ManyToOne(inversedBy: 'sportCourtAvailabilities')]
    #[ORM\JoinColumn(nullable: false, name: 'court_id', referencedColumnName: 'id')]
    private ?SportCourt $sportCourt = null;

    #[ORM\ManyToOne(inversedBy: 'sportCourtAvailabilities')]
    #[ORM\JoinColumn(nullable: false, name: 'day_id', referencedColumnName: 'id')]
    private ?DayOfWeek $dayOfWeek = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourtAvailabilityStartTime(): ?\DateTimeInterface
    {
        return $this->courtAvailabilityStartTime;
    }

    public function setCourtAvailabilityStartTime(\DateTimeInterface $courtAvailabilityStartTime): static
    {
        $this->courtAvailabilityStartTime = $courtAvailabilityStartTime;

        return $this;
    }

    public function getCourtAvailabilityEndTime(): ?\DateTimeInterface
    {
        return $this->courtAvailabilityEndTime;
    }

    public function setCourtAvailabilityEndTime(\DateTimeInterface $courtAvailabilityEndTime): static
    {
        $this->courtAvailabilityEndTime = $courtAvailabilityEndTime;

        return $this;
    }

    public function getSportCourt(): ?SportCourt
    {
        return $this->sportCourt;
    }

    public function setSportCourt(?SportCourt $sportCourt): static
    {
        $this->sportCourt = $sportCourt;

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
