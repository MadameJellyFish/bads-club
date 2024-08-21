<?php

namespace App\Handler;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\SwitchUserToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Handler
{
    private ?User $user = null;

    private ?User $connectedUser = null;

    protected EntityManagerInterface $entityManager;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        $token = $tokenStorage->getToken();
        if ($token === null) {
            return;
        }
        
        $this->user = $token->getUser();
        if ($token instanceof SwitchUserToken) {
            $this->connectedUser = $token->getOriginalToken()->getUser();
        }
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getConnectedUser(): ?User 
    {
        return $this->connectedUser;
    }
}