<?php

namespace App\Repository;

use App\Entity\UserAbsenceDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserAbsenceDocument|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAbsenceDocument|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAbsenceDocument[]    findAll()
 * @method UserAbsenceDocument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAbsenceDocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAbsenceDocument::class);
    }

    // /**
    //  * @return UserAbsenceDocument[] Returns an array of UserAbsenceDocument objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserAbsenceDocument
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
