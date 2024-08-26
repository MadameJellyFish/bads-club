<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

     /**
     * @return ?User
     */
    public function getOneWithDetails($user): ?User
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.sports', 'us')
            ->leftJoin('us.sport', 's')
            ->leftJoin('us.practiceLevel', 'pl')
            ->leftJoin('u.address', 'uad')
            ->leftJoin('u.reservations', 'ur')
            ->leftJoin('ur.status', 'rs')
            ->leftJoin('u.availabilities', 'ua')
            ->addSelect('us', 's', 'pl', 'uad', 'ur', 'rs', 'ua')
            ->addSelect('us', 's', 'pl')
            ->where('u = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult();
    }
}