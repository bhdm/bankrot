<?php

namespace Bankrot\SiteBundle\Controller;

use Bankrot\SiteBundle\Entity\Subscription;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class
 * @Security("has_role('ROLE_USER')")
 * @Route("/subscription")
 */
class SubscriptionController extends Controller
{
    /**
     * @Route("/", name="subscription_index")
     * @Template("")
     */
    public function indexAction(){
        $subscription = new Subscription();
        $form = $this->createFormBuilder($subscription)
            ->add('count', 'choice', array(
                'label' =>'Выберите период оплаты',
                'choices' => array(
                    '1' => '1 месяц',
                    '3' => '3 месяца',
                    '6' => '6 месяцев',
                    '12' => '12 месяцев',
                )
            ))
            ->add('submit','submit', array('label'=> 'Оплатить', 'attr' => array('class' => 'btn-primary')))
            ->getForm();

        $subscriptions = $this->getDoctrine()->getRepository('BankrotSiteBundle:Subscription')->findByUser($this->getUser());

        return array('form' => $form->createView(),'subscriptions' => $subscriptions);
    }


    /**
     * @Route("/", name="subscription_success")
     * @Template("")
     */
    public function successAction(){
        return array();
    }


}