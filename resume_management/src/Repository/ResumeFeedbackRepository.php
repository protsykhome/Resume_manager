<?php

namespace App\Repository;

use App\Entity\ResumeFeedback;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ResumeFeedback>
 *
 * @method ResumeFeedback|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResumeFeedback|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResumeFeedback[]    findAll()
 * @method ResumeFeedback[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResumeFeedbackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResumeFeedback::class);
    }

//    /**
//     * @return ResumeFeedback[] Returns an array of ResumeFeedback objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ResumeFeedback
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
