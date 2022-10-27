<?php

namespace App\Repository;

use App\Entity\Lieux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lieux>
 *
 * @method Lieux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lieux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lieux[]    findAll()
 * @method Lieux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LieuxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lieux::class);
    }

    public function save(Lieux $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Lieux $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Lieux[] Returns an array of Lieux objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Lieux
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findWithPagination($page, $limit){
        $qb = $this->createQueryBuilder("l")
        ->setMaxResults($limit)
        ->setFirstResult(($page - 1) * $limit);

        return $qb->getQuery()->getResult();
    }

    public function findWithStatus(){
        $qb = $this->createQueryBuilder('l')
                    ->andWhere('l.status = 1');

        return $qb->getQuery()->getResult();
    }
}
