<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`users`')]
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

    #[ORM\ManyToOne(targetEntity: Address::class)]
    #[ORM\JoinColumn(name: "address_id", referencedColumnName: "id", nullable: true)]
    private ?Address $address = null;

    /**
     * @var Collection<int, UserReservation>
     */
    #[ORM\OneToMany(targetEntity: UserReservation::class, mappedBy: 'user')]
    private Collection $user_reservations;

    /**
     * @var Collection<int, UserSport>
     */
    #[ORM\OneToMany(targetEntity: UserSport::class, mappedBy: 'user')]
    private Collection $user_sports;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $last_name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthdate = null;

    public function __construct()
    {
        $this->user_reservations = new ArrayCollection();
        $this->user_sports = new ArrayCollection();
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
        return $this->user_reservations;
    }

    public function addUserReservation(UserReservation $userReservation): static
    {
        if (!$this->user_reservations->contains($userReservation)) {
            $this->user_reservations->add($userReservation);
            $userReservation->setUser($this);
        }

        return $this;
    }

    public function removeUserReservation(UserReservation $userReservation): static
    {
        if ($this->user_reservations->removeElement($userReservation)) {
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
        return $this->user_sports;
    }

    public function addSportId(UserSport $sportId): static
    {
        if (!$this->user_sports->contains($sportId)) {
            $this->user_sports->add($sportId);
            $sportId->setUser($this);
        }

        return $this;
    }

    public function removeSportId(UserSport $sportId): static
    {
        if ($this->user_sports->removeElement($sportId)) {
            // set the owning side to null (unless already changed)
            if ($sportId->getUser() === $this) {
                $sportId->setUser(null);
            }
        }

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }
}