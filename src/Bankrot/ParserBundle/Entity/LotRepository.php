<?php

namespace Bankrot\ParserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class LotRepository extends EntityRepository
{
    public function search($search = null , $filter = array()){

        $str = " ( r.number LIKE '%$search%' OR
                d.name LIKE '%$search%' OR
                a.val LIKE '%$search%' OR
                rc.val LIKE '%$search%' )
   ";

        $dq = $this
            ->createQueryBuilder('r')
            ->leftJoin('r.debtor','d')
            ->leftJoin('r.attrs','a')
            ->leftJoin('r.status','st')
            ->leftJoin('r.type','t')
            ->leftJoin('r.priceType','pt')
            ->leftJoin('r.contents','rc')


            ->where($str);

            if ($filter['createdAt']){
                $filter['createdAt'] = new \DateTime($filter['createdAt']);
                $date1 = $filter['createdAt']->format('Y-m-d').' 00:00:00';
                $date2 = $filter['createdAt']->format('Y-m-d').' 23:59:59';
                $dq->andWhere("r.createdAt > '$date1'");
                $dq->andWhere("r.createdAt < '$date2'");
            }
            if ($filter['bidAt']){
                $filter['bidAt'] = new \DateTime($filter['bidAt']);
                $date1 = $filter['bidAt']->format('Y-m-d').' 00:00:00';
                $date2 = $filter['bidAt']->format('Y-m-d').' 23:59:59';
                $dq->andWhere("r.bidAt > '$date1'");
                $dq->andWhere("r.bidAt < '$date2'");
            }
            if ($filter['status']){
                $dq->andWhere("st.id = '$filter[status]'");
            }
            if ($filter['view']){
                $dq->andWhere("t.id = '$filter[view]'");
            }
            if ($filter['forma']){
                $dq->andWhere("pt.id = '$filter[forma]'");
            }

            $result = $dq->orderBy('r.createdAt', 'DESC')
            ->getQuery();
//            ->getResult();
        return $result;
    }

}