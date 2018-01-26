<?php

namespace App\Repository;

use App\Entity\Locker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class LockerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Locker::class);
    }

    public function findInUseLocker(string $number): ?Locker
    {
        return $this
            ->createQueryBuilder('l')
            ->where('l.status = :status')
            ->andWhere('l.number = :number')
            ->setParameter('status', Locker::IN_USE)
            ->setParameter('number', $number)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
