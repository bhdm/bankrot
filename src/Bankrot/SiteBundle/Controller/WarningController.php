<?php

namespace Bankrot\SiteBundle\Controller;

use Bankrot\ParserBundle\Parser\UserAgentGenerator;
use Bankrot\SiteBundle\Entity\Arbitration;
use Bankrot\SiteBundle\Entity\Registry;
use Bankrot\SiteBundle\Form\ArbitrationType;
use Bankrot\SiteBundle\Form\RegistryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RegistryController
 * @package Bankrot\SiteBundle\Controller
 * @Route("/warning")
 */
class WarningController extends Controller
{
    /**
     * @Route("/registry", name="warning_registry_list")
     * @Template()
     */
    public function registryAction(Request $request){
        $items = $this->getDoctrine()->getRepository('BankrotSiteBundle:Registry')->findBy(array('enabled' => true),['id' => 'DESC']);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $this->get('request')->query->get('page', 1),
            50
        );
        $em = $this->getDoctrine()->getManager();
        $item = new Registry();
        $form = $this->createForm(new RegistryType($em), $item);
        $formData = $form->handleRequest($request);
        return array('pagination' => $pagination, 'form' => $formData->createView());
    }

    /**
     * @Route("/registry-add", name="warning_registry_add")
     * @Template()
     */
    public function addRegistryAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $item = new Registry();
        $form = $this->createForm(new RegistryType($em), $item);
        $formData = $form->handleRequest($request);
        if ($request->getMethod() == 'POST') {
            if ($formData->isValid()) {
                $item = $formData->getData();
                $em->persist($item);
                $em->flush();
                $em->refresh($item);
            }
        }
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/arbitration", name="warning_arbitration_list")
     * @Template()
     */
    public function arbitrationAction(Request $request){
        $items = $this->getDoctrine()->getRepository('BankrotSiteBundle:Arbitration')->findBy(array('enabled' => true),['id' => 'DESC']);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $this->get('request')->query->get('page', 1),
            50
        );
        $em = $this->getDoctrine()->getManager();
        $item = new Arbitration();
        $form = $this->createForm(new ArbitrationType($em), $item);
        $formData = $form->handleRequest($request);
        return array('pagination' => $pagination, 'form' => $formData->createView());
    }

    /**
     * @Route("/arbitration-add", name="warning_arbitration_add")
     * @Template()
     */
    public function addArbitrationAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $item = new Arbitration();
        $form = $this->createForm(new ArbitrationType($em), $item);
        $formData = $form->handleRequest($request);
        if ($request->getMethod() == 'POST') {
            if ($formData->isValid()) {
                $item = $formData->getData();
                $em->persist($item);
                $em->flush();
                $em->refresh($item);
            }
        }
        return $this->redirect($request->headers->get('referer'));
    }
}