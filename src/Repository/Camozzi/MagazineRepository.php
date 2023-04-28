<?php

namespace App\Repository\Camozzi;

use App\Entity\Camozzi\Magazine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Magazine>
 *
 * @method Magazine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Magazine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Magazine[]    findAll()
 * @method Magazine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MagazineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Magazine::class);
    }

    public function save(Magazine $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Magazine $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByCriteria(
        array $where = [], array $orderBy = [], int $limit = 25, int $offset = 0
    ): array
    {
        $query = $this->createQueryBuilder('m');

        foreach ($where as $attribute => $condition) {
            $query->andWhere("m.$attribute LIKE :$attribute");
            $query->setParameter($attribute, "%$condition%");
        }

        foreach ($orderBy as $attribute => $condition) {
            $query->orderBy("m.$attribute", $condition);
        }

        return $query
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $value
     * @return array Returns an array of Magazine objects
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getMagazineCount(): array
    {
        return $this->createQueryBuilder('m')
            ->select('COUNT(m.id) AS count')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult()
        ;
    }

//    /**
//     * @return Magazine[] Returns an array of Magazine objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Magazine
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
