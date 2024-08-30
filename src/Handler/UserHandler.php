<?php

namespace App\Handler;

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
        
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->getOneWithDetails($user);
        
        $sports = $user->getUserSports()->map(fn($userSport) => [
            'sportName' => $userSport->getSport()->getsportName(),
            'practiceLevel' => $userSport->getPracticeLevel()->getLevelName(),
        ])->toArray();
        
        $address = $user->getAddress() ? [
            'address' => $user->getAddress()->getAddress(),
            'zipcode'  => $user->getAddress()->getZipcode(),
            'city' => $user->getAddress()->getCity(),
            'country' => $user->getAddress()->getCountry(),
        ] : "";
        
        $userReservations = $user->getUserReservations()->map(fn($reservation) => [
            'reservationDate' => $reservation->getReservationDate()->format('Y-m-d H:i:s'),
            'status' => $reservation->getStatus()->getStatusName(),
        ])->toArray();
        
        $userAvailabilities = $user->getUserAvailabilities()->map(fn($userAvailability) => [
            'dayOfWeek' => $userAvailability->getDayOfWeek()->getDayName(),
            'startTime' => $userAvailability->getUserAvailabilityStartTime()->format('H:i'),
            'endTime' => $userAvailability->getUserAvailabilityEndTime()->format('H:i'),
        ])->toArray();

        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
            'sports' => $sports,
            'address' => $address,
            'userReservations' => $userReservations,
            'userAvailabilities' => $userAvailabilities,
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
}