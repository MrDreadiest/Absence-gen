<?php

namespace App\Repository;

use App\Entity\UserAbsenceDocumentHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserAbsenceDocumentHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAbsenceDocumentHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAbsenceDocumentHistory[]    findAll()
 * @method UserAbsenceDocumentHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAbsenceDocumentHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAbsenceDocumentHistory::class);
    }

    // /**
    //  * @return UserAbsenceDocumentHistory[] Returns an array of UserAbsenceDocumentHistory objects
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
    public function findOneBySomeField($value): ?UserAbsenceDocumentHistory
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
