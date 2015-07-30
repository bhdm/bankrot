<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PageRepository")
 */
class Reestr extends BaseEntity
{


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fio;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $number;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $registerDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $openDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cpo;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $rating;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $debtorCategory;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $debtorInn;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $debtorOgrn;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $debtorRegion;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $debtorAdrs;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $debtorTitle;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $debtorFullTitle;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $organizatorTitle;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $organizatorRegion;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $organizatorAdrs;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $organizatorInn;

    /**
     * @return mixed
     */
    public function getFio()
    {
        return $this->fio;
    }

    /**
     * @param mixed $fio
     */
    public function setFio($fio)
    {
        $this->fio = $fio;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    /**
     * @param mixed $registerDate
     */
    public function setRegisterDate($registerDate)
    {
        $this->registerDate = $registerDate;
    }

    /**
     * @return mixed
     */
    public function getOpenDate()
    {
        return $this->openDate;
    }

    /**
     * @param mixed $openDate
     */
    public function setOpenDate($openDate)
    {
        $this->openDate = $openDate;
    }

    /**
     * @return mixed
     */
    public function getCpo()
    {
        return $this->cpo;
    }

    /**
     * @param mixed $cpo
     */
    public function setCpo($cpo)
    {
        $this->cpo = $cpo;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getDebtorCategory()
    {
        return $this->debtorCategory;
    }

    /**
     * @param mixed $debtorCategory
     */
    public function setDebtorCategory($debtorCategory)
    {
        $this->debtorCategory = $debtorCategory;
    }

    /**
     * @return mixed
     */
    public function getDebtorInn()
    {
        return $this->debtorInn;
    }

    /**
     * @param mixed $debtorInn
     */
    public function setDebtorInn($debtorInn)
    {
        $this->debtorInn = $debtorInn;
    }

    /**
     * @return mixed
     */
    public function getDebtorOgrn()
    {
        return $this->debtorOgrn;
    }

    /**
     * @param mixed $debtorOgrn
     */
    public function setDebtorOgrn($debtorOgrn)
    {
        $this->debtorOgrn = $debtorOgrn;
    }

    /**
     * @return mixed
     */
    public function getDebtorRegion()
    {
        return $this->debtorRegion;
    }

    /**
     * @param mixed $debtorRegion
     */
    public function setDebtorRegion($debtorRegion)
    {
        $this->debtorRegion = $debtorRegion;
    }

    /**
     * @return mixed
     */
    public function getDebtorAdrs()
    {
        return $this->debtorAdrs;
    }

    /**
     * @param mixed $debtorAdrs
     */
    public function setDebtorAdrs($debtorAdrs)
    {
        $this->debtorAdrs = $debtorAdrs;
    }

    /**
     * @return mixed
     */
    public function getDebtorTitle()
    {
        return $this->debtorTitle;
    }

    /**
     * @param mixed $debtorTitle
     */
    public function setDebtorTitle($debtorTitle)
    {
        $this->debtorTitle = $debtorTitle;
    }

    /**
     * @return mixed
     */
    public function getDebtorFullTitle()
    {
        return $this->debtorFullTitle;
    }

    /**
     * @param mixed $debtorFullTitle
     */
    public function setDebtorFullTitle($debtorFullTitle)
    {
        $this->debtorFullTitle = $debtorFullTitle;
    }

    /**
     * @return mixed
     */
    public function getOrganizatorTitle()
    {
        return $this->organizatorTitle;
    }

    /**
     * @param mixed $organizatorTitle
     */
    public function setOrganizatorTitle($organizatorTitle)
    {
        $this->organizatorTitle = $organizatorTitle;
    }

    /**
     * @return mixed
     */
    public function getOrganizatorRegion()
    {
        return $this->organizatorRegion;
    }

    /**
     * @param mixed $organizatorRegion
     */
    public function setOrganizatorRegion($organizatorRegion)
    {
        $this->organizatorRegion = $organizatorRegion;
    }

    /**
     * @return mixed
     */
    public function getOrganizatorAdrs()
    {
        return $this->organizatorAdrs;
    }

    /**
     * @param mixed $organizatorAdrs
     */
    public function setOrganizatorAdrs($organizatorAdrs)
    {
        $this->organizatorAdrs = $organizatorAdrs;
    }

    /**
     * @return mixed
     */
    public function getOrganizatorInn()
    {
        return $this->organizatorInn;
    }

    /**
     * @param mixed $organizatorInn
     */
    public function setOrganizatorInn($organizatorInn)
    {
        $this->organizatorInn = $organizatorInn;
    }


}