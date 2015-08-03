<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ReestrRepository extends EntityRepository
{
    public function search($type, $search = null){

        $str = "( r.aShotTitle          LIKE '%$search%' OR
                r.aFullTitle          LIKE '%$search%' OR
                r.aAdrs               LIKE '%$search%' OR
                r.aRegion             LIKE '%$search%' OR
                r.aSubCategory        LIKE '%$search%' OR
                r.aInn                LIKE '%$search%' OR
                r.aOgrn               LIKE '%$search%' OR
                r.aForma              LIKE '%$search%'
                )
   ";

        $result= $this
            ->createQueryBuilder('r')
//            ->from('BankrotSiteBundle:Reestr','r')
            ->where('r.category = '.$type)
            ->andWhere($str)
            ->getQuery()
            ->getResult();
        return $result;
    }

}