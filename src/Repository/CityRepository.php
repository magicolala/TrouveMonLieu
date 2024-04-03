<?php

namespace App\Repository;

use App\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<City>
 *
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 * @method City[]    findAll()
 * @method City[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, City::class);
    }
    public function findRandomCity(): ?City
    {
        $qb = $this->createQueryBuilder('c');
        $totalCities = $qb->select('COUNT(c.id)')->getQuery()->getSingleScalarResult();
    
        if ($totalCities > 0) {
            $randomIndex = rand(0, $totalCities - 1);
    
            $qb = $this->createQueryBuilder('c');
            $qb->select('c')
                ->orderBy('c.id', 'ASC')
                ->setFirstResult($randomIndex)
                ->setMaxResults(1);
    
            return $qb->getQuery()->getOneOrNullResult();
        }
    
        return null;
    }

    public function save(City $city, bool $flush = false): void
    {
        $this->getEntityManager()->persist($city);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(City $city, bool $flush = false): void
    {
        $this->getEntityManager()->remove($city);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
      
}
