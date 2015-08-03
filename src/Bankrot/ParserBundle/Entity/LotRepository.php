<?php

namespace Bankrot\ParserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class LotRepository extends EntityRepository
{
    public function search($search = null){

        $str = " r.number LIKE '%$search%' OR
                d.name LIKE '%$search%' OR
                a.val LIKE '%$search%'
   ";

//        OR
//        r.aFullTitle          LIKE '%$search%' OR
//        r.aAdrs               LIKE '%$search%' OR
//        r.aRegion             LIKE '%$search%' OR
//        r.aSubCategory        LIKE '%$search%' OR
//        r.aInn                LIKE '%$search%' OR
//        r.aOgrn               LIKE '%$search%' OR
//        r.aForma              LIKE '%$search%'

        $result= $this
            ->createQueryBuilder('r')
            ->leftJoin('r.debtor','d')
            ->leftJoin('r.attrs','a')
            ->where($str)
            ->getQuery()
            ->getResult();
        return $result;
    }

}