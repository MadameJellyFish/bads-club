<?php

namespace App\Entity;

use App\Repository\SportRepository;
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
}
