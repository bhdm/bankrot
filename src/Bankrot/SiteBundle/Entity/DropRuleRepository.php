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
    public function search($lotId, $lastDropRule){
        if ($lastDropRule === null){
            $lastDropRule = 0;
        }
        $result = $this
            ->createQueryBuilder('dr')
            ->select('dr')
            ->where("dr.lot = :lotId")
            ->andWhere('dr.id > :lastDropRule')
            ->setParameter('lotId',$lotId)
            ->setParameter('lastDropRule',$lastDropRule)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        return $result;
    }
}
