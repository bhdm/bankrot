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
                r.aForma              LIKE '%$search%' OR
                r.bTitle              LIKE '%$search%' OR
                r.bNumber             LIKE '%$search%' OR
                r.bRegisterDate       LIKE '%$search%' OR
                r.bInn                LIKE '%$search%' OR
                r.bAdrsCpo            LIKE '%$search%' OR
                r.bAdrsReestr         LIKE '%$search%' OR
                r.bAdrsMail           LIKE '%$search%' OR
                r.bPhone              LIKE '%$search%' OR
                r.bEmail              LIKE '%$search%' OR
                r.bSite               LIKE '%$search%' OR
                r.bSizeFondCpo        LIKE '%$search%' OR
                r.bDateFondCpo        LIKE '%$search%' OR
                r.bSizeFondReestr     LIKE '%$search%' OR
                r.bManager            LIKE '%$search%' OR
                r.bContact            LIKE '%$search%' OR
                r.bCountManager       LIKE '%$search%'
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