<?php

namespace App\Repository;

use App\Entity\Manga;
use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Manga>
 *
 * @method Manga|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manga|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manga[]    findAll()
 * @method Manga[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MangaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manga::class);
    }

    public function save(Manga $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Manga $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBySerie(Serie $serie): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.serie = :serie')
            ->orderBy('m.volume_number', 'ASC')
            ->setParameter('serie', $serie)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllOrderBy(string $param, string $order)
    {
        return $this->findBy(array(), array($param => $order));
    }

//    /**
//     * @return Manga[] Returns an array of Manga objects
//     */

//    public function findOneBySomeField($value): ?Manga
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
