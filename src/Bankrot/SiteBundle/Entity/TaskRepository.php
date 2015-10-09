<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TaskRepository extends EntityRepository
{
    public function findTaskByDate($year, $month, $day, $userId, $lotId = null)
    {
//        $emConfig = $this->getEntityManager()->getConfiguration();
//        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
//        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');

        $date = $year.'-'.$month.'-'.$day;
        $result= $this
            ->createQueryBuilder('t')
            ->leftJoin('t.user', 'u');

//        if ($lotId != null){
//            $result->leftJoin('t.lot', 'l')
//                ->where('l.id = :lotId')
//                ->setParameter('lotId',$lotId);
//        }else{
//            $result->where('t.lot is null');
//        }
        $result->andWhere('t.date >= :date1')
            ->andWhere('t.date <= :date2')
            ->andWhere('u.id = :userId')
            ->setParameters([
                'date1' => $date.' 00:00:00',
                'date2' => $date.' 23:59:59',
                'userId' => $userId,
            ]);
        $result = $result->getQuery()->getResult();
        return $result;
    }
}
