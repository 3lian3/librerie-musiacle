<?php

namespace App\Repository;

use App\Entity\Album;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query;
use Doctrine\ORM\Query as ORMQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Album>
 *
 * @method Album|null find($id, $lockMode = null, $lockVersion = null)
 * @method Album|null findOneBy(array $criteria, array $orderBy = null)
 * @method Album[]    findAll()
 * @method Album[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Album::class);
    }

   /**
    * @return Query Returns an array of Album objects
    */
    
   public function listeAlbumsCompletePaginee(): ?ORMQuery
   {
       return $this->createQueryBuilder('a')
            ->select('a', 's', 'art', 'm')
            ->leftJoin('a.styles', 's')
            ->leftJoin('a.artiste', 'art')
            ->leftJoin('a.morceaux', 'm')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
       ;
   }

//    public function findOneBySomeField($value): ?Album
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
