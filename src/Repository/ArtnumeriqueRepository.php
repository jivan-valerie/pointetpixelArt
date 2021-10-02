<?php

namespace App\Repository;

use App\Entity\Artnumerique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Artnumerique|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artnumerique|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artnumerique[]    findAll()
 * @method Artnumerique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtnumeriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artnumerique::class);
    }

     /**
      * @return Artnumerique[] Returns an array of Artnumerique objects
     */
    
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function findAuteur()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.auteur', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Artnumerique
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
