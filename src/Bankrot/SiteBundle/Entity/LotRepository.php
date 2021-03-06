<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\EntityRepository;

class LotRepository extends EntityRepository
{
    public function findActiveLots($owner, $search=null)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('lw')
            ->from('BankrotSiteBundle:LotWatch', 'lw')
            ->leftJoin('BankrotSiteBundle:Lot', 'l', 'WITH', 'l = lw.lot')
            ->leftJoin('BankrotSiteBundle:LotStatus', 'ls', 'WITH', 'ls = l.lotStatus')
            ->leftJoin('BankrotSiteBundle:Category', 'c', 'WITH', 'c = l.category')
            ->where($qb->expr()->andX(
                $qb->expr()->eq('lw.owner', ':owner'),
                $qb->expr()->isNotNull('l.initialPrice'),
//                $qb->expr()->isNull('ls.isTrash')
                $qb->expr()->andX('ls.isTrash != 1 OR ls.isTrash is NULL')
            ))
            ->setParameter('owner', $owner);
        if (!empty($search)) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('c.name', ':search'),
                $qb->expr()->like('l.name', ':search')
            ))->setParameter('search', "%$search%");
        }

//        echo $qb->getQuery()->getSQL();
//        exit;
        return $qb->getQuery()->getResult();
    }

    public function findInactiveLots(User $owner)
    {
        $qb = $this->createQueryBuilder('l');
        $qb
            ->leftJoin('BankrotSiteBundle:LotWatch', 'lw', 'WITH', 'lw.lot = l')
            ->leftJoin('BankrotSiteBundle:LotStatus', 'ls', 'WITH', 'ls = l.lotStatus')
//            ->where($qb->expr()->andX(
//                $qb->expr()->eq('l.owner', ':owner')
//                $qb->expr()->isNull('l.initialPrice'),
//                $qb->expr()->eq('ls.isTrash', 0)
//            ))
            ->where('lw.id is NULL')
            ->andWhere('l.owner = :owner ')
            ->andWhere('ls.id IS NULL OR ( ls.id != 9 AND ls.id != 10)')
            ->groupBy('l.id')
            ->orderBy('l.createdAt', 'desc')
            ->setParameters([
                'owner' => $owner,
            ]);

//        echo $qb->getQuery()->getSQL();
//        exit;
        return $qb->getQuery()
            ->getResult();
    }

    public function findArchiveLots(User $owner, $status = null)
    {
        $qb = $this->createQueryBuilder('l');
        $qb
            ->innerJoin('BankrotSiteBundle:LotStatus', 'ls', 'WITH', 'ls = l.lotStatus');
            if ($status != null){
                $qb->where($qb->expr()->andX(
                    $qb->expr()->eq('l.owner', ':owner'),
                    $qb->expr()->eq('ls.isTrash', 1),
                    $qb->expr()->eq('ls.id', $status)
                ));
            }else{
                $qb->where($qb->expr()->andX(
                    $qb->expr()->eq('l.owner', ':owner'),
                    $qb->expr()->eq('ls.isTrash', 1)
                ));
            }
            $qb->orderBy('l.createdAt', 'desc')
            ->setParameters([
                'owner' => $owner,
            ]);

        return $qb->getQuery()
            ->getResult();
    }

}
