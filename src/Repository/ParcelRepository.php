<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Parcel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Parcel>
 *
 * @method Parcel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parcel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parcel[]    findAll()
 * @method Parcel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParcelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parcel::class);
    }

    public function findBySenderPhone(string $phone): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.sender', 's')
            ->where('s.phone = :phone')
            ->setParameter('phone', $phone)
            ->getQuery()
            ->getResult();
    }

    public function findByReceiverFullName(string $fullName): array
    {
        $nameParts = preg_split('/\s+/', strtoupper($fullName));

        return $this->createQueryBuilder('p')
            ->join('p.recipient', 'r')
            ->join('r.fullName', 'rf')
            ->where('UPPER(rf.lastName) = :lastName')
            ->andWhere('UPPER(rf.firstName) = :firstName')
            ->andWhere('UPPER(rf.middleName) = :middleName')
            ->setParameter('lastName', $nameParts[0])
            ->setParameter('firstName', $nameParts[1])
            ->setParameter('middleName', $nameParts[2])
            ->getQuery()
            ->getResult();
    }
}
