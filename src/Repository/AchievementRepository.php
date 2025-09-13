<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Achievement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AchievementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Achievement::class);
    }

    public function getRandomAchievementsWithPower(int $power, int $maxResults): array
    {

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('achievement')
            ->from('App\Entity\Achievement', 'achievement')
            ->orderBy('RAND()')
            ->where('achievement.power = :power')
            ->setParameter('power', $power)
            ->setMaxResults($maxResults);

        return $qb->getQuery()->getResult();
    }
}
