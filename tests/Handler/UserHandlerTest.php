<?php

namespace App\Tests\Handler;

use App\Entity\User;
use App\Handler\UserHandler;
use Symfony\Component\Uid\Uuid;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserHandlerTest extends KernelTestCase
{
    private MockObject|EntityManagerInterface $entityManager;
    private MockObject|TokenStorageInterface $tokenStorage;
    private UserHandler $userHandler;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->tokenStorage = $this->createMock(TokenStorageInterface::class);

        $this->userHandler = new UserHandler($this->tokenStorage, $this->entityManager);
    }

    public function testGetAllUsers(): void
    {
        $userRepository = $this->createMock(UserRepository::class);
        $user1 = $this->createMock(User::class);
        $user2 = $this->createMock(User::class);

        $uuid1 = Uuid::fromString('f00f3c8e-a1cc-4864-99ed-950af43ffe87');
        $uuid2 = Uuid::fromString('e01f3c8e-b1dc-4864-98ed-850af43ffe88');

        $user1->method('getId')->willReturn($uuid1);
        $user1->method('getEmail')->willReturn('user1@example.com');
        $user1->method('getRoles')->willReturn(['ROLE_USER']);

        $user2->method('getId')->willReturn($uuid2);
        $user2->method('getEmail')->willReturn('user2@example.com');
        $user2->method('getRoles')->willReturn(['ROLE_USER']);

        $userRepository->method('findAll')->willReturn([$user1, $user2]);

        $this->entityManager->method('getRepository')->willReturn($userRepository);

        $result = $this->userHandler->getAllUsers();

        $this->assertEquals([
            [
                'id' => $uuid1->toRfc4122(), 
                'email' => 'user1@example.com',
                'roles' => ['ROLE_USER']
            ],
            [
                'id' => $uuid2->toRfc4122(),
                'email' => 'user2@example.com',
                'roles' => ['ROLE_USER']
            ],
        ], $result);
    }

    public function testGetAllUsersWithoutUsers(): void
    {
        $userRepository = $this->createMock(UserRepository::class);

        $userRepository->method('findAll')->willReturn([]);

        $this->entityManager->method('getRepository')->willReturn($userRepository);

        $result = $this->userHandler->getAllUsers();

        $this->assertEmpty($result);
    }
}