<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;
    
    /**
     * @var list<string> The user roles
     */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToOne]
    private ?Address $address = null;

    /**
     * @var Collection<int, UserReservation>
     */
    #[ORM\OneToMany(targetEntity: UserReservation::class, mappedBy: 'user')]
    private Collection $userReservations;

    /**
     * @var Collection<int, UserSport>
     */
    #[ORM\OneToMany(targetEntity: UserSport::class, mappedBy: 'user_id')]
    private Collection $sport_id;

    public function __construct()
    {
        $this->userReservations = new ArrayCollection();
        $this->sport_id = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, UserReservation>
     */
    public function getUserReservations(): Collection
    {
        return $this->userReservations;
    }

    public function addUserReservation(UserReservation $userReservation): static
    {
        if (!$this->userReservations->contains($userReservation)) {
            $this->userReservations->add($userReservation);
            $userReservation->setUser($this);
        }

        return $this;
    }

    public function removeUserReservation(UserReservation $userReservation): static
    {
        if ($this->userReservations->removeElement($userReservation)) {
            // set the owning side to null (unless already changed)
            if ($userReservation->getUser() === $this) {
                $userReservation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserSport>
     */
    public function getSportId(): Collection
    {
        return $this->sport_id;
    }

    public function addSportId(UserSport $sportId): static
    {
        if (!$this->sport_id->contains($sportId)) {
            $this->sport_id->add($sportId);
            $sportId->setUser($this);
        }

        return $this;
    }

    public function removeSportId(UserSport $sportId): static
    {
        if ($this->sport_id->removeElement($sportId)) {
            // set the owning side to null (unless already changed)
            if ($sportId->getUser() === $this) {
                $sportId->setUser(null);
            }
        }

        return $this;
    }
}