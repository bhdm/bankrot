<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ReestrRepository extends EntityRepository
{
    public function search($type, $search = null){

        if ($type == 0){
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
        }
        if ($type == 1){
            $str = "( r.bTitle          LIKE '%$search%' OR
                r.bNumber          LIKE '%$search%' OR
                r.bManager          LIKE '%$search%' OR
                r.bInn               LIKE '%$search%' OR
                r.bPhone             LIKE '%$search%' OR
                r.bEmail        LIKE '%$search%'
                )
            ";
        }

        if ($type == 2){
            $str = "( r.cLastName          LIKE '%$search%' OR
                r.cNumber          LIKE '%$search%' OR
                r.cCpo               LIKE '%$search%'
                )
            ";
        }

        if ($type == 3){
            $str = "( r.dFullTitle          LIKE '%$search%' OR
                r.dPhone          LIKE '%$search%' OR
                r.dRegion               LIKE '%$search%' OR
                r.dInn               LIKE '%$search%' OR
                r.dOgrn               LIKE '%$search%' OR
                r.dOkpo               LIKE '%$search%'
                )
            ";
        }

        if ($type == 4){
            $str = "(
                r.eTitle          LIKE '%$search%' OR
                r.eSite               LIKE '%$search%' OR
                r.eOgrn               LIKE '%$search%'
                )
            ";
        }

        if ($type == 5){
            $str = "(
                r.fFio          LIKE '%$search%' OR
                r.fTitleOrgan               LIKE '%$search%' OR
                r.fQualification               LIKE '%$search%' OR
                r.fDisqualification               LIKE '%$search%'
                )
            ";
        }


        if ($type == 7){
            $str = "(
                r.gWinner          LIKE '%$search%'
                )
            ";
        }

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