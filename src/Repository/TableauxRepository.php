<?php

namespace App\Repository;

use App\Entity\Tableaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tableaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tableaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tableaux[]    findAll()
 * @method Tableaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TableauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tableaux::class);
    }

     /**
      * @return Tableaux[] Returns an array of Tableaux objects
      */
    public function findArtist()
    {
        return $this->createQueryBuilder('t')
            ->select('distinct t.auteur')
            // ->groupBy('t.auteur')
            // ->select('t.titre')

            ->getQuery()
            ->getResult()
        ;
    }
    // public function findByCategory($criteria)
    // {
    //     return $this->createQueryBuilder('t')
    //        ->leftJoin('t.categories', 'category') 
    //         ->where()
    //        ->andWhere('t. = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('t.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
    

    /*
    public function findOneBySomeField($value): ?Tableaux
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
