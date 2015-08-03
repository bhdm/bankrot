<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ForumAnswerRepository extends EntityRepository
{
    public function search($string){
        $result= $this
            ->createQueryBuilder('f')
            ->from('bankrotSiteBundle:ForumAnswer','f')
            ->where('f.body LIKE %:string% ')
            ->setParameter('string', $string)
            ->getQuery()
            ->getResult();
        return $result;
    }

}