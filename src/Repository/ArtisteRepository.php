<?php

namespace App\Repository;

use App\Entity\Artiste;
use Doctrine\DBAL\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query as ORMQuery;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Artiste>
 *
 * @method Artiste|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artiste|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artiste[]    findAll()
 * @method Artiste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtisteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artiste::class);
    }

   /**
    * @return Query Returns an array of Artiste objects
    */

   public function listeArtistesComplete(): ?ORMQuery
   {
       return $this->createQueryBuilder('art')
            ->select('art', 'a')
            ->leftJoin('art.albums', 'a')
            ->orderBy('art.nom', 'ASC')
            ->getQuery()
       ;
   }

   /**
    * @return Query Returns an array of Artiste objects
    */

   public function listeArtistesCompletePaginee(): ?ORMQuery
   {
       return $this->createQueryBuilder('art')
            ->select('art', 'a')
            ->leftJoin('art.albums', 'a')
            ->orderBy('art.nom', 'ASC')
            ->getQuery()
       ;
   }

   public function listeArtisteSimple(): ?QueryBuilder
   {
        return $this->createQueryBuilder('art')
                    ->orderBy('art.nom', 'ASC');
   }

//    public function findOneBySomeField($value): ?Artiste
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
