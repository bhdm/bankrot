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
     * @Route("/lots/archive/{status}", name="lots_list_archive", defaults={"status" = 0})
     * @Template()
     */
    public function archiveAction($status)
    {
        if ($status == 0){
            $status = 9;
        }else{
            $status = 10;
        }
        $lots = $this->getDoctrine()
            ->getManager()
            ->getRepository('BankrotSiteBundle:Lot')
            ->findArchiveLots($this->getUser(),$status);

        return [
            'lots' => $lots,
            'status' => $status,
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

        $lw = $this->getDoctrine()->getRepository('BankrotSiteBundle:LotWatch')->findByLot($lot);
        return [
            'lot' => $lot,
            'form' => $form->createView(),
            'lw' => $lw
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
        $dropRule = $this->getDoctrine()->getRepository('BankrotSiteBundle:DropRule')->findBy(array('lot' => $lot),['beginDate' => 'ASC']);

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
//                foreach($dropRule as $dr){
//                    if (
//                        $dr->getBeginDate()->format('Ymd') <= $calendar->getYear() . $calendar->getMonthD() . $tmp_element
//                        &&
//                        $dr->getEndDate()->format('Ymd') >= $calendar->getYear() . $calendar->getMonthD() . $tmp_element
//                    ){
//                        # Если попали сюда, то за данный день отвечает этот dropRule
//                        #Дата начала отсчитывания
//                        $date1 = strtotime($dr->getBeginDate()->format('Y-m-d'));
//
//                        #Дата текущей ячейки
//                        $date2 = $calendar->getYear() .'-'. $calendar->getMonthD() .'-'. $tmp_element;
//                        $date2 = strtotime($date2);
//
//                        #Кол-во отсчетов
//                        $diff = $date2-$date1;
//                        $diff = floor($diff/(60*60*24));
//                        $diff = $diff / $dr->getPeriod();
//                        $diff =  floor($diff);
//
//                        if ($dr->getOrder()){
//                            # в процентах от начальной суммы
//                            $monthTable[$rowKey][$colKey]['price'] = $lot->getInitialPrice() - ($lot->getInitialPrice()/100*$dr->getOrder())*$diff;
//
//                        }else{
//                            # в процентах от текущего периода
//                            if ($dr->getOrderCurrent()){
//                                $price = $lot->getInitialPrice();
//                                for ($k = 0; $k <= $diff; $k ++){
//                                    $price +=  ($price/100*$dr->getOrder());
//                                }
//                                $monthTable[$rowKey][$colKey]['price'] = $lot->getInitialPrice() - $price;
//                            }else{
//                                $monthTable[$rowKey][$colKey]['price'] = $lot->getInitialPrice();
//                            }
//                        }
//                        # Если стоимость отсечения меньше
//                        if ($monthTable[$rowKey][$colKey]['price'] < $lot->getCutOffPrice()){
//                            $monthTable[$rowKey][$colKey]['price']  = $lot->getCutOffPrice();
//                        }
//                        $lastPrice = $monthTable[$rowKey][$colKey]['price'];
//
//                        # Теперь просчитываем стоимость задатка
//                        if ($lot->getDepositPrice()){
//                            $monthTable[$rowKey][$colKey]['depositPrice']  = $lot->getDepositPrice();
//                        }elseif($lot->getDepositPricePercent()){
//                            $monthTable[$rowKey][$colKey]['depositPrice']  = $lot->getInitialPrice()/100*$lot->getDepositPricePercent();
//                        }elseif($lot->getDepositPricePercentCurrent()){
//                            $monthTable[$rowKey][$colKey]['depositPrice']  = $monthTable[$rowKey][$colKey]['price']/100*$lot->getDepositPricePercent();
//                        }else{
//                            $monthTable[$rowKey][$colKey]['depositPrice']  = 0;
//                        }
//
//                    }
//                }

            }
        }


        $currentDate = $lot->getBeginDate();
        $si = 0;
        $currentPeriod = 0;
        $dr = null;
        $price = $lot->getInitialPrice();
        $depositPrice = $lot->getInitialPrice();
//        $priceBeginPeriod = $lot->getInitialPrice();
        while (true){

            # Находим день недели этого дня
            $dint = mktime (0,0,0,$currentDate->format('m'),$currentDate->format('d'),$currentDate->format('Y'));
            $den = date("w",$dint);
            if($den==0) $den=7;
            $plus=7-$den;
            $week = ceil((date("j",$dint)+$plus)/7);
            $week = $week-1;
            $dayOfWeek = date("w", mktime(0,0,0,$currentDate->format('m'),$currentDate->format('d'),$currentDate->format('Y')));
            if ($dayOfWeek == 0){
                $dayOfWeek = 7;
            }
            $dayOfWeek --;

            $item = &$monthTable[$week][$dayOfWeek];

            # получаем DropRule
            if ( $dr == null || $dr->getEndDate() < $currentDate || $dr->getBeginDate() > $currentDate ){
                $dr = $this->getDoctrine()->getRepository('BankrotSiteBundle:DropRule')->search($lotId,$currentDate);
                if ($dr){
                    # Если новый DR обнуляем период и начальная стоимость в этом периоде
                    $priceBeginPeriod = $price;
                    $currentPeriod = 0;
                }
            }

            if ($dr){

                if ($dr->getPeriod()){
                    $currentPeriod ++;
                }elseif($dr->getPeriodWork() && $dayOfWeek < 5){
                    $currentPeriod ++;
                }

                # Высчитываем price
                if (($dr->getPeriod() && $currentPeriod == $dr->getPeriod()) || ($dr->getPeriodWork() && $currentPeriod == $dr->getPeriodWork())){
                    if ($dr->getOrder()){
                        # в процентах от начальной суммы
                        $price -= ($lot->getInitialPrice()/100*$dr->getOrder());
                    }elseif ($dr->getOrderCurrent()){
                        # в процентах от текущего периода
                        $price -= $price - ($priceBeginPeriod/100*$dr->getOrderCurrent());
                    }
                }



                    # Если стоимость отсечения меньше
                    if ($price < $lot->getCutOffPrice()){
                        $price  = $lot->getCutOffPrice();
                    }
                $lastPrice = $price;
            }


            # Теперь просчитываем стоимость задатка
            if ($lot->getDepositPrice()){
                $depositPrice = $lot->getDepositPrice();
            }elseif($lot->getDepositPricePercent()){
                $depositPrice = $lot->getInitialPrice()/100*$lot->getDepositPricePercent();
            }elseif($lot->getDepositPricePercentCurrent()){
                $depositPrice = $priceBeginPeriod/100*$lot->getDepositPricePercentCurrent();
            }else{
                $depositPrice = 0;
            }


            # Записываем информацию о цене
            if (isset($item['number']) && $item['number'] == (int) $currentDate->format('d')){
                $item['price'] = $price;
                $item['depositPrice'] = $depositPrice;
            }





            if (isset($dr)){
                if (($dr->getPeriod() && $currentPeriod == $dr->getPeriod()) || ($dr->getPeriodWork() && $currentPeriod == $dr->getPeriodWork())){
                    $currentPeriod = 0;
                }
            }


           $currentDate->modify('+1 day');
           if ($currentDate > $lot->getEndDate()){
               break;
           }
            # Максимальный срок лота 100 дней, потом можно увеличить
           $si++;
           if ($si > 100){
               break;
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
            $dep = $request->request->get('dep');
            $lot = $this->getDoctrine()->getRepository('BankrotSiteBundle:Lot')->findOneById($lotId);
            if ($lot){
                $show = $this->getDoctrine()->getRepository('BankrotSiteBundle:LotWatch')->findOneBy(array('lot' => $lot, 'day' => $date));
                if (!$show){
                    $show = new LotWatch();
                    $show->setOwner($this->getUser());
                    $show->setDay($date);
                    $show->setLot($lot);
                    $show->setPrice($price);
                    $show->setDeposity($dep);
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

    /**
     * @Route("/lots/remove-lot/{id}", name="remove_lot")
     */
    public function removeLotItemAction(Request $request, $id){
        $lot = $this->getDoctrine()->getRepository('BankrotSiteBundle:Lot')->findOneById($id);
        if ($lot->getOwner() == $this->getUser()){
            $em = $this->getDoctrine()->getManager();
//            $lot->setOwner(null);
//            $em->flush($lot);
            $em->refresh($lot);
            $em->remove($lot);
            $em->flush($lot);
        }

        return $this->redirect($this->generateUrl('lots_list'));

    }

    /**
     * @Route("/lots/removeShow/{id}", name="remove_lot_show")
     */
    public function removeLotShowAction(Request $request, $id){
        $show = $this->getDoctrine()->getRepository('BankrotSiteBundle:LotWatch')->findOneByid($id);
        $this->getDoctrine()->getManager()->remove($show);
        $this->getDoctrine()->getManager()->flush($show);
        return $this->redirect($request->headers->get('referer'));

    }
}
