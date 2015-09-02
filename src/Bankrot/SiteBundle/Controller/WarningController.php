<?php

namespace Bankrot\SiteBundle\Controller;

use Bankrot\ParserBundle\Parser\UserAgentGenerator;
use Bankrot\SiteBundle\Entity\Arbitration;
use Bankrot\SiteBundle\Entity\Registry;
use Bankrot\SiteBundle\Entity\WarningComment;
use Bankrot\SiteBundle\Form\ArbitrationType;
use Bankrot\SiteBundle\Form\RegistryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
                $item->setEnabled(false);
                $item->setUser($this->getUser());
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
                $item->setEnabled(false);
                $item->setUser($this->getUser());
                $em->persist($item);
                $em->flush();
                $em->refresh($item);
            }
        }
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Security("has_role('ROLE_SUBSCRIPTION')")
     * @Route("/arbitration-show/{id}", name="warning_arbitration_show")
     * @Template()
     */
    public function showArbitrationAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $warning = $this->getDoctrine()->getRepository('BankrotSiteBundle:Arbitration')->findOneById($id);
        $comment = new WarningComment();
        $form = $this->createFormBuilder($comment)
            ->add('body', 'textarea', ['label' => 'Сообщение'])
            ->add('submit', 'submit', ['label' => 'Отправить', 'attr' => ['class' => 'btn-primary']])->getForm();
        $formData = $form->handleRequest($request);
        if ($formData->isValid()) {
            $comment = $formData->getData();
            $comment->setUser($this->getUser());
            $comment->setArbitration($warning);
            $em->persist($comment);
            $em->flush($comment);
        }
        return ['warning' => $warning, 'form' => $form->createView()];
    }

    /**
     * @Security("has_role('ROLE_SUBSCRIPTION')")
     * @Route("/registry-show/{id}", name="warning_registry_show")
     * @Template()
     */
    public function showRegistryAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $warning = $this->getDoctrine()->getRepository('BankrotSiteBundle:Registry')->findOneById($id);
        $comment = new WarningComment();
        $form = $this->createFormBuilder($comment)
            ->add('body', 'textarea', ['label' => 'Сообщение'])
            ->add('submit', 'submit', ['label' => 'Отправить', 'attr' => ['class' => 'btn-primary']])->getForm();
        $formData = $form->handleRequest($request);
        if ($formData->isValid()) {
            $comment = $formData->getData();
            $comment->setUser($this->getUser());
            $comment->setRegistry($warning);
            $em->persist($comment);
            $em->flush($comment);
        }
        return ['warning' => $warning, 'form' => $form->createView()];
    }
}