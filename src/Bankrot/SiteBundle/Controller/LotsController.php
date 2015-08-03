<?php

namespace Bankrot\SiteBundle\Controller;

use Bankrot\SiteBundle\Entity\DropRule;
use Bankrot\SiteBundle\Entity\Lot;
use Bankrot\SiteBundle\Entity\LotRepository;
use Bankrot\SiteBundle\Entity\LotWatch;
use Bankrot\SiteBundle\Service\Calendar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LotsController
 * @package Bankrot\SiteBundle\Controller
  @Security("has_role('ROLE_USER')")
 */
class LotsController extends Controller
{
    /**
     * @Route("/lots", name="lots_list")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        /**
         * @var $repository LotRepository
         */
        $repository = $this->getDoctrine()->getManager()->getRepository('BankrotSiteBundle:Lot');
        $search = $request->query->get('search');
        if ($this->getUser()){
            $user = $this->getUser()->getId();
        }else{
            $user = null;
        }
        $lots = $repository->findActiveLots($user, $search);

        return compact('lots');
    }

    /**
     * @Route("/lots/inactive", name="lots_list_inactive")
     * @Template()
     */
    public function inactiveAction()
    {
        $lots = $this->getDoctrine()
            ->getManager()
            ->getRepository('BankrotSiteBundle:Lot')
            ->findInactiveLots($this->getUser());

        return [
            'lots' => $lots,
        ];
    }

    /**
     * @Route("/lots/archive", name="lots_list_archive")
     * @Template()
     */
    public function archiveAction()
    {
        $lots = $this->getDoctrine()
            ->getManager()
            ->getRepository('BankrotSiteBundle:Lot')
            ->findArchiveLots($this->getUser());

        return [
            'lots' => $lots,
        ];
    }

    /**
     * @Route("/lots/add", name="lots_add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm('lot');

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $lotDate = $form->getData();
                $lot = new Lot();
                $lot->setData($lotDate);
                $livePeriod = $request->request->get('lot')['livePeriod'];
                $isValid = true;

                if (preg_match('/^[\d\.]+ - [\d\.]+$/', $livePeriod, $m)) {
                    $m[0] = explode('-', $m[0]);

                    try {
                        $lot->setBeginDate(new \DateTime($m[0][0]));
                        $lot->setEndDate(new \DateTime($m[0][1]));
                    } catch (\Exception $e) {
                        $form->get('livePeriod')->addError(new FormError('Неверный формат записи'));
                        $isValid = false;
                    }
                }

                if ($request->request->get('lot')['newDropRulePeriod']){
                    $newDropRulePeriod = $request->request->get('lot')['newDropRulePeriod'];
                    $newDropRulePeriodWork = $request->request->get('lot')['newDropRulePeriodWork'];
                    $newDropRuleOrder = $request->request->get('lot')['newDropRuleOrder'];
                    $newDropRuleOrderCurrent = $request->request->get('lot')['newDropRuleOrderCurrent'];
                    $newDropRuleLivePeriod = $request->request->get('lot')['newDropRuleLivePeriod'];

                    if ($newDropRulePeriod || $newDropRulePeriodWork) {
                        $newDropRule = new DropRule();

                        if ($newDropRulePeriod) $newDropRule->setPeriod($newDropRulePeriod);
                        if ($newDropRulePeriodWork) $newDropRule->setPeriodWork($newDropRulePeriodWork);

                        if ($newDropRuleOrder || $newDropRuleOrderCurrent) {
                            if ($newDropRuleOrder) $newDropRule->setOrder($newDropRuleOrder);
                            if ($newDropRuleOrderCurrent) $newDropRule->setOrderCurrent($newDropRuleOrderCurrent);

                            if (preg_match('/^[\d\.]+ - [\d\.]+$/', $newDropRuleLivePeriod, $m)) {
                                $m[0] = explode('-', $m[0]);

                                try {
                                    $newDropRule->setBeginDate(new \DateTime($m[0][0]));
                                    $newDropRule->setEndDate(new \DateTime($m[0][1]));
                                } catch (\Exception $e) {
                                    $form->get('newDropRuleLivePeriod')->addError(new FormError('Неверный формат записи'));
                                    $isValid = false;
                                }
                            }


                        }
                    }
                }

                if ($isValid) {
                    if (isset($newDropRule) && $newDropRule){
                        $em->persist($newDropRule);
                        $em->flush($newDropRule);
                        $em->refresh($newDropRule);
                        $lot->addDropRule($newDropRule);
                    }
                    $lot->setOwner($this->getUser());
//                    $lot->setCategory(null);
                    $em->persist($lot);
                    $em->flush();

                    return $this->redirectToRoute('lots_edit', ['id' => $lot->getId()]);
                }
            }
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/lots/{id}/edit", name="lots_edit", requirements={"id": "\d+"})
     * @ParamConverter("lot", class="BankrotSiteBundle:Lot")
     * @Template()
     */
    public function editAction(Request $request, Lot $lot)
    {
        $form = $this->createForm('lot', $lot);

        if ($lot->getBeginDate() && $lot->getEndDate()) {
            $form->get('livePeriod')->setData(sprintf('%s - %s',
                $lot->getBeginDate()->format('d.m.Y'),
                $lot->getEndDate()->format('d.m.Y')
            ));
        }

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $livePeriod = $request->request->get('lot')['livePeriod'];
                $isValid = true;

                if (preg_match('/^[\d\.]+ - [\d\.]+$/', $livePeriod, $m)) {
                    $m[0] = explode('-', $m[0]);

                    try {
                        $lot->setBeginDate(new \DateTime($m[0][0]));
                        $lot->setEndDate(new \DateTime($m[0][1]));
                    } catch (\Exception $e) {
                        $form->get('livePeriod')->addError(new FormError('Неверный формат записи'));
                        $isValid = false;
                    }
                } else {
                    $lot->setBeginDate(null);
                    $lot->setEndDate(null);
                }

                $newDropRulePeriod = $request->request->get('lot')['newDropRulePeriod'];
                $newDropRulePeriodWork = $request->request->get('lot')['newDropRulePeriodWork'];
                $newDropRuleOrder = $request->request->get('lot')['newDropRuleOrder'];
                $newDropRuleOrderCurrent = $request->request->get('lot')['newDropRuleOrderCurrent'];
                $newDropRuleLivePeriod = $request->request->get('lot')['newDropRuleLivePeriod'];

                if ($newDropRulePeriod || $newDropRulePeriodWork) {
                    $newDropRule = new DropRule();

                    if ($newDropRulePeriod) $newDropRule->setPeriod($newDropRulePeriod);
                    if ($newDropRulePeriodWork) $newDropRule->setPeriodWork($newDropRulePeriodWork);

                    if ($newDropRuleOrder || $newDropRuleOrderCurrent) {
                        if ($newDropRuleOrder) $newDropRule->setOrder($newDropRuleOrder);
                        if ($newDropRuleOrderCurrent) $newDropRule->setOrderCurrent($newDropRuleOrderCurrent);

                        if (preg_match('/^[\d\.]+ - [\d\.]+$/', $newDropRuleLivePeriod, $m)) {
                            $m[0] = explode('-', $m[0]);

                            try {
                                $newDropRule->setBeginDate(new \DateTime($m[0][0]));
                                $newDropRule->setEndDate(new \DateTime($m[0][1]));
                            } catch (\Exception $e) {
                                $form->get('newDropRuleLivePeriod')->addError(new FormError('Неверный формат записи'));
                                $isValid = false;
                            }
                        }

                        $lot->addDropRule($newDropRule);
                    }
                }

                if ($isValid) {
                    $em->persist($lot);
                    $em->flush();

                    return $this->redirectToRoute('lots_edit', ['id' => $lot->getId()]);
                }
            }
        }

        return [
            'lot' => $lot,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/lots/{id}", name="lots", requirements={"id": "\d+"})
     * @ParamConverter("lot", class="BankrotSiteBundle:Lot")
     * @Template()
     */
    public function showAction(Lot $lot)
    {
        $form = $this->createForm('lot', $lot, [
            'disabled' => true,
        ]);

        return [
            'lot' => $lot,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/api/v1/lots/{id}/drop-rules/{dr_id}/remove", requirements={"id": "\d+", "dr_id": "\d+"})
     * @ParamConverter("dropRule", class="BankrotSiteBundle:DropRule", options={"id": "dr_id"})
     */
    public function removeDropRuleAction(Lot $lot, DropRule $dropRule)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($dropRule);
        $em->flush();

        return new JsonResponse(true);
    }


    /**
     * Показывает календарь событий на данный месяц данного года
     * @Route("/lots/calendar/{lotId}/{year}/{month}", name = "calendar", options={"expose"=true} , defaults = {"year" = null, "month" = null}, requirements = {"year" = "\d+", "month" = "\d+"})
     */
    public function calendarAction($lotId, $year, $month)
    {
        $calendar = new Calendar();
        $calendar->setMonth($month);
        $calendar->setYear($year);
        $lot = $this->getDoctrine()->getRepository('BankrotSiteBundle:Lot')->findOneById($lotId);
        $events = $this->getDoctrine()->getRepository('BankrotSiteBundle:LotWatch')->findByLot($lot);
        $dropRule = $this->getDoctrine()->getRepository('BankrotSiteBundle:DropRule')->findByLot($lot);

        $monthTable     = $calendar->getMonthTable();
        $numberOfEvents = count($events);

        foreach ($monthTable as $rowKey => $row) {
            foreach ($monthTable[$rowKey] as $colKey => $element) {
                if ($element) {
                    $monthTable[$rowKey][$colKey]['events'] = array();
                }
                if ($element['number'] < 10) {
                    $tmp_element = '0' . $element['number'];
                }
                else {
                    $tmp_element = $element['number'];
                }
                for ($i = 0; $i < $numberOfEvents; $i++) {
                    #Здесь к каждому дню приписываем следим или нет в этом лоте
                    if ($events[$i]->getDay()->format('Ymd') == $calendar->getYear() . $calendar->getMonthD() . $tmp_element ) {
                        $monthTable[$rowKey][$colKey]['events'][] = $events[$i]->getLot()->getName();
                    }
                }
                #Здесь к каждому дню приписываем следим или нет в этом лоте
                $lastPrice = $lot->getInitialPrice();
                foreach($dropRule as $dr){
                    if (
                        $dr->getBeginDate()->format('Ymd') <= $calendar->getYear() . $calendar->getMonthD() . $tmp_element
                        &&
                        $dr->getEndDate()->format('Ymd') >= $calendar->getYear() . $calendar->getMonthD() . $tmp_element
                    ){
                        # Если попали сюда, то за данный день отвечает этот dropRule

                        #Дата начала отсчитывания
                        $date1 = strtotime($dr->getBeginDate()->format('Y-m-d'));

                        #Дата текущей ячейки
                        $date2 = $calendar->getYear() .'-'. $calendar->getMonthD() .'-'. $tmp_element;
                        $date2 = strtotime($date2);

                        #Кол-во отсчетов
                        $diff = $date2-$date1;
                        $diff = floor($diff/(60*60*24));
                        $diff = $diff / $dr->getPeriod();
                        $diff =  floor($diff);

                        if ($dr->getOrder()){
                            # в процентах от начальной суммы
                            $monthTable[$rowKey][$colKey]['price'] = $lot->getInitialPrice() - ($lot->getInitialPrice()/100*$dr->getOrder())*$diff;

                        }else{
                            # в процентах от текущего периода
                            if ($dr->getOrderCurrent()){
                                $price = $lot->getInitialPrice();
                                for ($k = 0; $k <= $diff; $k ++){
                                    $price +=  ($price/100*$dr->getOrder());
                                }
                                $monthTable[$rowKey][$colKey]['price'] = $lot->getInitialPrice() - $price;
                            }else{
                                $monthTable[$rowKey][$colKey]['price'] = $lot->getInitialPrice();
                            }
                        }
                        # Если стоимость отсечения меньше
                        if ($monthTable[$rowKey][$colKey]['price'] < $lot->getCutOffPrice()){
                            $monthTable[$rowKey][$colKey]['price']  = $lot->getCutOffPrice();
                        }
                        $lastPrice = $monthTable[$rowKey][$colKey]['price'];

                        # Теперь просчитываем стоимость задатка
                        if ($lot->getDepositPrice()){
                            $monthTable[$rowKey][$colKey]['depositPrice']  = $lot->getDepositPrice();
                        }elseif($lot->getDepositPricePercent()){
                            $monthTable[$rowKey][$colKey]['depositPrice']  = $lot->getInitialPrice()/100*$lot->getDepositPricePercent();
                        }elseif($lot->getDepositPricePercentCurrent()){
                            $monthTable[$rowKey][$colKey]['depositPrice']  = $monthTable[$rowKey][$colKey]['price']/100*$lot->getDepositPricePercent();
                        }else{
                            $monthTable[$rowKey][$colKey]['depositPrice']  = 0;
                        }

                    }
                }
            }
        }

        $em = $this->getDoctrine()->getManager();

        $nowYear  = date('Y', time()) + 1; //Добавляем год что бы посмотреть события и на следующий год
        $fullYear = $month === '0';

        return $this->render('BankrotSiteBundle:Lots:calendar.html.twig', array(
            'calendar'        => $monthTable,
            'monthName'       => $calendar->getMonthName(),
            'year'            => $calendar->getYear(),
            'month'           => $calendar->getMonth(),
            'fullYear'        => $fullYear,
            'nextMonth'       => $calendar->getNextMonth(),
            'prevMonth'       => $calendar->getPrevMonth(),
            'nextMonthYear'   => $calendar->getNextMonthYear(),
            'prevMonthYear'   => $calendar->getPrevMonthYear(),
            'events'          => $events,
            'typeCalendar'    => 'all',
            'lot'             => $lot
        ));
    }

    /**
     * @Route("/lots/addShow/{lotId}", name="add_lot_show", options={"expose"=true})
     */
    public function addLotShowAction(Request $request, $lotId){
        if ($request->getMethod() == 'POST'){
            $date = new \DateTime($request->request->get('date'));
            $price = $request->request->get('price');
            $lot = $this->getDoctrine()->getRepository('BankrotSiteBundle:Lot')->findOneById($lotId);
            if ($lot){
                $show = $this->getDoctrine()->getRepository('BankrotSiteBundle:LotWatch')->findOneBy(array('lot' => $lot, 'day' => $date));
                if (!$show){
                    $show = new LotWatch();
                    $show->setOwner($this->getUser());
                    $show->setDay($date);
                    $show->setLot($lot);
                    $show->setPrice($price);
                    $this->getDoctrine()->getManager()->persist($show);
                    $this->getDoctrine()->getManager()->flush($show);
                    return new JsonResponse('add');
                }else{
                    $this->getDoctrine()->getManager()->remove($show);
                    $this->getDoctrine()->getManager()->flush($show);
                    return new JsonResponse('remove');
                }
            }
        }
    }
}