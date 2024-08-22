<?php

namespace App\Handler;

use App\Entity\Sport;
use App\Entity\SportCourt;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SportHandler extends Handler
{
    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
        parent::__construct($tokenStorage, $entityManager);
    }

    public function getAllSportsWithCourts(): array
    {
        $sportRepository = $this->entityManager->getRepository(Sport::class);
        $sports = $sportRepository->findAllWithCourts();

        return array_map(fn(Sport $sport) => [
            'sport_id' => $sport->getId(),
            'sport_name' => $sport->getSportName(),
            'sport_courts' => array_map(fn(SportCourt $court) => [
                'court_id' => $court->getId(),
                'court_name' => $court->getCourtName()
            ], $sport->getSportCourts()->toArray())
        ], $sports);
    }
}