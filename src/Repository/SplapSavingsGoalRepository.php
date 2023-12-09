<?php

namespace App\Repository;

use App\Entity\SplapSavingsGoal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SplapSavingsGoal>
 *
 * @method SplapSavingsGoal|null find($id, $lockMode = null, $lockVersion = null)
 * @method SplapSavingsGoal|null findOneBy(array $criteria, array $orderBy = null)
 * @method SplapSavingsGoal[]    findAll()
 * @method SplapSavingsGoal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SplapSavingsGoalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SplapSavingsGoal::class);
    }

//    /**
//     * @return SplapSavingsGoal[] Returns an array of SplapSavingsGoal objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SplapSavingsGoal
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
