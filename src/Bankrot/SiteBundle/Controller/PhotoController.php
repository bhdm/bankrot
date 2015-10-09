<?php

namespace Bankrot\SiteBundle\Controller;

use Bankrot\ParserBundle\Entity\Trader;
use Bankrot\ParserBundle\Parser\UserAgentGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhotoController extends Controller
{

    /**
     * @Route("/photo/list/{lotId}")
     * @Template()
     */
    public function listAction(Request $request, $lotId)
    {
        $lot = $this->getDoctrine()->getRepository('BankrotSiteBundle:Lot')->findOneBy(['id' => $lotId]);
        if ($lot->getOwner()->getId() != $this->getUser()->getId()){
            throw $this->createAccessDeniedException('ошибка доступа');
        }
        $photos = $this->getDoctrine()->getRepository('BankrotSiteBundle:LotPhoto')->findByLot($lot);

        return ['photos' => $photos];
    }

    /**
     * @Route("/photo/add/{lotId}")
     * @Template()
     */
    public function addAction(Request $request, $lotId){
        $lot = $this->getDoctrine()->getRepository('BankrotSiteBundle:Lot')->findOneBy(['id' => $lotId]);
        if ($lot->getOwner()->getId() != $this->getUser()->getId()){
            throw $this->createAccessDeniedException('ошибка доступа');
        }
        
    }
}