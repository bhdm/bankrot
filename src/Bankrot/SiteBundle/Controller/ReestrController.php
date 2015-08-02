<?php

namespace Bankrot\SiteBundle\Controller;

use Bankrot\ParserBundle\Parser\UserAgentGenerator;
use Bankrot\SiteBundle\Form\ReestrType;
use Bankrot\SiteBundle\Form\Type\ReestrShowType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     * @Route("/list/{type}", name="reestr_list" , defaults={"type"=0})
     * @Template("")
     */
    public function listAction($type = 0){
        $items = $this->getDoctrine()->getRepository('BankrotSiteBundle:Reestr')->findByCategory($type);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $this->get('request')->query->get('page', 1),
            50
        );

        return array('pagination' => $pagination, 'type' => $type );
    }

    /**
     * @Security("has_role('ROLE_SUBSCRIPTION')")
     * @Route("/list/{type}/{id}", name="reestr_show")
     * @Template("")
     */
    public function showAction($type, $id){
        $reestr = $this->getDoctrine()->getRepository('BankrotSiteBundle:Reestr')->findOneById($id);
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm( new ReestrShowType($em),$reestr, [
            'disabled' => true,
        ]);

        return array(
            'reestr' => $reestr,
            'type' => $type,
            'form' => $form->createView(),
        );
    }
}