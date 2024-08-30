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
        $user->setEmail('x@gmail.com');
        $user->setPassword('password');
        $user->setFirstName('Xiomi');
        $user->setLastName('Camargo');

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $userFromDb = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'x@gmail.com']);
        $this->assertNotNull($userFromDb);
        $this->assertEquals('Xiomi', $userFromDb->getFirstName());
        $this->assertEquals('Camargo', $userFromDb->getLastName());
    }
}