<?php

namespace App\Handler;

use App\Entity\Address;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserHandler extends Handler
{
    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
        parent::__construct($tokenStorage, $entityManager);
    }

    public function getUserProfileInfos(): array
    {
        $user = $this->getUser();
        if ($user === null) {
            return [];
        }

        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'birthdate' => $user->getBirthdate(),
            'address' => $user->getAddress()->getAddress(),
            'zipcode'  => $user->getAddress()->getZipcode(),
            'city' => $user->getAddress()->getCity(),
            'country' => $user->getAddress()->getCountry(),
        ];
    }

    public function getAllUsers(): array
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $users = $userRepository->findAll();

        return array_map(fn(User $user) => [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles()
        ], $users);
    }

    public function getUserAddress(): ?Address
    {
        $user = $this->getUser();
        if ($user === null) {
            return [];
        }

        $address = $user->getAddress();
        return $address;
    }
}