<?php

namespace Bankrot\SiteBundle\Controller;

use Bankrot\ParserBundle\Parser\UserAgentGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RegistryController
 * @package Bankrot\SiteBundle\Controller
 * @Route("/reestr")
 */
class ReestrController extends Controller
{
    /**
     * @Route("/list", name="reestr_list")
     * @Template("")
     */
    public function listAction(){
        $items = $this->getDoctrine()->getRepository('BankrotSiteBundle:Reestr')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $this->get('request')->query->get('page', 1),
            50
        );

        return array('pagination' => $pagination);
    }
}