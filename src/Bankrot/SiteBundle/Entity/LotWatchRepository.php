<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\EntityRepository;

class LotWatchRepository extends EntityRepository
{
    public function findEvent($date, $string, $userId)
    {
        if ($string == 'arhive'){
            $date = $date->modify('+1 day');
            $qb = $this->createQueryBuilder('lw')
                ->leftJoin('lw.owner','u')
                ->where("lw.day = '".$date->format('Y-m-d')." 00:00:00'")
                ->andWhere('u.id = '.$userId);
//                ->setParameter('d',$date->format('Y-m-d').' 00:00:00');
        }

        if ($string == 'control'){
            $date = $date->modify('+5 day');
            $qb = $this->createQueryBuilder('lw')
                ->leftJoin('lw.owner','u')
                ->where("lw.day = '".$date->format('Y-m-d')." 00:00:00'")
                ->andWhere('u.id = '.$userId);
//                ->setParameter('d',$date->format('Y-m-d').' 00:00:00');
        }

        if ($string == 'active'){
            $qb = $this->createQueryBuilder('lw')
                ->leftJoin('lw.owner','u')
                ->where("lw.day = '".$date->format('Y-m-d')." 00:00:00'")
                ->andWhere('u.id = '.$userId);
//                ->setParameter('d',$date->format('Y-m-d').' 00:00:00');
        }
        $result =  $qb->getQuery()->getResult();

        return $result;

    }
}