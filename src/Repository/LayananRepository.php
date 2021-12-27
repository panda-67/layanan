<?php

namespace App\Repository;

use App\Entity\Layanan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Layanan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Layanan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Layanan[]    findAll()
 * @method Layanan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LayananRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Layanan::class);
    }

    // /**
    //  * @return Layanan[] Returns an array of Layanan objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Layanan
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
