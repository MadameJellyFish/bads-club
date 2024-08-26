<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RegisterControllerTest extends KernelTestCase 
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
    }

    public function testUserCreate(): void
    {
        $user = new User();
        $user->setEmail('bea@gmail.com');
        $user->setPassword('password');
        $user->setFirstName('Beatriz');
        $user->setLastName('Camargo');

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $userFromDb = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'bea@gmail.com']);
        $this->assertNotNull($userFromDb);
        $this->assertEquals('Beatriz', $userFromDb->getFirstName());
        $this->assertEquals('Camargo', $userFromDb->getLastName());
    }
}