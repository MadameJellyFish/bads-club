<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Table(name: '`addresses`')]
#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 20)]
    private ?string $zipcode = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'address')]
    private Collection $uuid;

    public function __construct()
    {
        $this->uuid = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): static
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserUuid(): Collection
    {
        return $this->uuid;
    }

    public function addUserUuid(User $userUuid): static
    {
        if (!$this->uuid->contains($userUuid)) {
            $this->uuid->add($userUuid);
            $userUuid->setAddress($this);
        }

        return $this;
    }

    public function removeUserUuid(User $userUuid): static
    {
        if ($this->uuid->removeElement($userUuid)) {
            // set the owning side to null (unless already changed)
            if ($userUuid->getAddress() === $this) {
                $userUuid->setAddress(null);
            }
        }

        return $this;
    }
}
