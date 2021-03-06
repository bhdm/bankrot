<?php
namespace Bankrot\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Bankrot\SiteBundle\Entity\Reestr;
use Bankrot\SiteBundle\Form\ReestrType;

/**
 * Class ReestrController
 * @package Bankrot\AdminBundle\Controller
 * @Route("/admin/reestr")
 */
class ReestrController extends Controller{
        const ENTITY_NAME = 'Reestr';
    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{type}", name="admin_reestr_list", defaults={"type" = 0})
     * @Template()
     */
    public function listAction($type = 0){
        $items = $this->getDoctrine()->getRepository('BankrotSiteBundle:'.self::ENTITY_NAME)->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $this->get('request')->query->get('page', 1),
            20
        );

        return array('pagination' => $pagination, 'type' => $type);
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/add", name="admin_reestr_add")
     * @Template()
     */
    public function addAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $item = new Reestr();
        $form = $this->createForm(new ReestrType($em), $item);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() == 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $item->setUser($this->getUser());
                $em->persist($item);
                $em->flush();
                $em->refresh($item);
                return $this->redirect($this->generateUrl('admin_reestr_list'));
            }
        }
        return array('form' => $form->createView());
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/edit/{id}", name="admin_reestr_edit")
     * @Template()
     */
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()->getRepository('BankrotSiteBundle:'.self::ENTITY_NAME)->findOneById($id);
        $form = $this->createForm(new ReestrType($em), $item);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() == 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->flush($item);
                $em->refresh($item);
                return $this->redirect($this->generateUrl('admin_reestr_list'));
            }
        }
        return array('form' => $form->createView());
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/remove/{id}", name="admin_reestr_remove")
     */
    public function removeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('BankrotSiteBundle:'.self::ENTITY_NAME)->findOneById($id);
        if ($item){
            $em->remove($item);
            $em->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }
}