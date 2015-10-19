<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\EntityRepository;

class DropRuleRepository extends EntityRepository
{
    /**
     * Находит ближайший период данного лота, который соответсвует дате
     * @param $lotId
     * @param $currentDate
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function search($lotId, $currentDate){
        $result = $this
            ->createQueryBuilder('dr')
            ->select('dr')
            ->where("dr.lot = :lotId")
            ->andWhere("dr.beginDate <= :curDate")
            ->andWhere("dr.endDate >= :curDate")
            ->setParameter('lotId',$lotId)
            ->setParameter('curDate',$currentDate->format('Y-m-d'))
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        return $result;
    }
}
