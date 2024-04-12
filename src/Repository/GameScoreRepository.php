<?php

namespace App\Repository;

use App\Entity\GameScore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GameScore>
 *
 * @method GameScore|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameScore|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameScore[]    findAll()
 * @method GameScore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameScoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameScore::class);
    }

    public function save(GameScore $gameScore, bool $flush = false): void
    {
        $this->getEntityManager()->persist($gameScore);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return GameScore[] Returns an array of GameScore objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?GameScore
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
