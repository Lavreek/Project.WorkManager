<?php

namespace App\Repository\MajorExpress;

use App\Entity\MajorExpress\CodeQueue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CodeQueue>
 *
 * @method CodeQueue|null find($id, $lockMode = null, $lockVersion = null)
 * @method CodeQueue|null findOneBy(array $criteria, array $orderBy = null)
 * @method CodeQueue[]    findAll()
 * @method CodeQueue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodeQueueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CodeQueue::class);
    }

    public function save(CodeQueue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CodeQueue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param $date
     * @return CodeQueue|null Returns an array of CodeQueue objects
     * @throws NonUniqueResultException
     */
    public function findByDate($date): CodeQueue|null
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.Status = 1')
            ->andWhere('c.Updated < :date')
            ->orWhere('c.Updated IS NULL')
            ->setParameter('date', $date)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

//    /**
//     * @return CodeQueue[] Returns an array of CodeQueue objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CodeQueue
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
