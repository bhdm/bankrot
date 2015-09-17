<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TaskRepository extends EntityRepository
{
    public function findTaskByDate($year, $month, $userId)
    {
//        $emConfig = $this->getEntityManager()->getConfiguration();
//        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
//        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');

        $result= $this
            ->createQueryBuilder('t')
            ->leftJoin('t.user', 'u')
            ->where('t.lot is null')
            ->andWhere('MONTH(t.date) = :month')
            ->andWhere('YEAR(t.date) = :year')
            ->andWhere('u.id = :userId')
            ->setParameters([
                'month' => $month,
                'year' => $year,
                'userId' => $userId,
            ])
            ->getQuery()
            ->getResult();
        return $result;
    }
}
