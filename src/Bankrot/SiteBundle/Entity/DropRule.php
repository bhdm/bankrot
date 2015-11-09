<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="DropRuleRepository")
 * @ORM\Table(name="drop_rules")
 */
class DropRule
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Lot", inversedBy="dropRules", cascade={"persist"})
     */
    private $lot;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $period;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $periodWork;

    /**
     * @ORM\Column(type="decimal", nullable=true, name="ordr", precision=4, scale=2)
     */
    private $order;

    /**
     * @ORM\Column(type="decimal", nullable=true, precision=4, scale=2)
     */
    private $orderCurrent;

    /**
     * @ORM\Column(type="date", name="begin_date", nullable=true)
     */
    private $beginDate;

    /**
     * @ORM\Column(type="date", name="end_date", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $percentPeriod;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isEnd = false;

    public function __construct()
    {
        $this->isEnd = false;
    }

    public function getId() { return $this->id; }

    public function setLot(Lot $lot) { $this->lot = $lot; }

    public function getLot() { return $this->lot; }

    public function setPeriod($period) { $this->period = $period; }

    public function getPeriod() { return $this->period; }

    public function setPeriodWork($periodWork) { $this->periodWork = $periodWork; }

    public function getPeriodWork() { return $this->periodWork; }

    public function setOrder($order) { $this->order = $order; }

    public function getOrder() { return $this->order; }

    public function setOrderCurrent($orderCurrent) { $this->orderCurrent = $orderCurrent; }

    public function getOrderCurrent() { return $this->orderCurrent; }

    public function setBeginDate($beginDate) { $this->beginDate = $beginDate; }

    public function getBeginDate() { return $this->beginDate; }

    public function setEndDate($endDate) { $this->endDate = $endDate; }

    public function getEndDate() { return $this->endDate; }

    public function __toString(){
        return ''.$this->period;
    }

    /**
     * @return mixed
     */
    public function getPercentPeriod()
    {
        return $this->percentPeriod;
    }

    /**
     * @param mixed $percentPeriod
     */
    public function setPercentPeriod($percentPeriod)
    {
        $this->percentPeriod = $percentPeriod;
    }

    /**
     * @return mixed
     */
    public function getIsEnd()
    {
        return $this->isEnd;
    }

    /**
     * @param mixed $isEnd
     */
    public function setIsEnd($isEnd)
    {
        $this->isEnd = $isEnd;
    }


}
