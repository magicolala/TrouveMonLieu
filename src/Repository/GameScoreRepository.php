<?php

namespace App\Repository;

use App\Entity\GameScore;
use App\Entity\User;
use App\Entity\Game;
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

    public function deleteScoresForUserAndGame(User $user, Game $game): void
    {
        $this->createQueryBuilder('gs')
            ->delete()
            ->where('gs.user = :user')
            ->andWhere('gs.game = :game')
            ->setParameter('user', $user)
            ->setParameter('game', $game)
            ->getQuery()
            ->execute();
    }

    public function findTotalScoreByGame(Game $game, User $user): ?int
    {
        $query = $this->createQueryBuilder('gs')
            ->select('gs.round AS round_id, MAX(gs.score) AS max_score')
            ->andWhere('gs.game = :game')
            ->andWhere('gs.user = :user')
            ->groupBy('gs.round')
            ->setParameter('game', $game)
            ->setParameter('user', $user)
            ->getQuery();

        $roundScores = $query->getResult();

        $totalBestScore = 0;
        foreach ($roundScores as $roundScore) {
            $totalBestScore += $roundScore['max_score'];
        }

        return $totalBestScore;
    }
}
