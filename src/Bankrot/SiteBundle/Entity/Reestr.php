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
     * Должники | CPO | Арбитражные управдяющие | Организаторы торгов | Торговые площадки | Дискалифицированные лица
     * @ORM\Column(type="string")
     */
    protected $category;


    # ##########
    # Должники #
    ############

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $aShotTitle;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $aFullTitle;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $aAdrs;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $aRegion;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $aSubCategory;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $aInn;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $aOgrn;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $aForma;


    # #####
    # CPO #
    #######

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $bTitle;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $bNumber;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $bRegisterDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $bInn;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $bAdrsCpo;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $bAdrsReestr;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $bAdrsMail;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $bPhone;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $bEmail;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $bSite;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $bSizeFondCpo;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $bDateFondCpo;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $bSizeFondReestr;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $bManager;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $bContact;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $bCountManager;


    # #########################
    # Арбитражные управляющие #
    ###########################

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cLastName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cFirstName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cSurName;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cInn;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cCpo;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $cDate;


    # #####################
    # Организаторы торгов #
    #######################

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $dShotTitle;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $dFullTitle;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $dAdrs;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $dPhone;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $dRegion;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $dInn;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $dKpp;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $dOgrn;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $dOkpo;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $dForma;


    # ###################
    # Торговые площадки #
    #####################

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $eTitle;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $eFullTitle;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $eSite;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $eAdrs;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $eInn;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $eOgrn;


    # ###########################
    # Дисквалифицированные лица #
    #############################

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fFio;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fBirthday;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fCountry;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fRegion;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fworkPlace;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fPost;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fSupreme;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fTitleOrgan;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fOffense;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fQualification;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $fOffenseDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fIssuedResolutionRegion;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fIssuedResolutionTitle;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $fIssuedDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fDisqualification;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $fDateStart;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $fDateEnd;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fNumber;

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getAShotTitle()
    {
        return $this->aShotTitle;
    }

    /**
     * @param mixed $aShotTitle
     */
    public function setAShotTitle($aShotTitle)
    {
        $this->aShotTitle = $aShotTitle;
    }

    /**
     * @return mixed
     */
    public function getAFullTitle()
    {
        return $this->aFullTitle;
    }

    /**
     * @param mixed $aFullTitle
     */
    public function setAFullTitle($aFullTitle)
    {
        $this->aFullTitle = $aFullTitle;
    }

    /**
     * @return mixed
     */
    public function getAAdrs()
    {
        return $this->aAdrs;
    }

    /**
     * @param mixed $aAdrs
     */
    public function setAAdrs($aAdrs)
    {
        $this->aAdrs = $aAdrs;
    }

    /**
     * @return mixed
     */
    public function getARegion()
    {
        return $this->aRegion;
    }

    /**
     * @param mixed $aRegion
     */
    public function setARegion($aRegion)
    {
        $this->aRegion = $aRegion;
    }

    /**
     * @return mixed
     */
    public function getASubCategory()
    {
        return $this->aSubCategory;
    }

    /**
     * @param mixed $aSubCategory
     */
    public function setASubCategory($aSubCategory)
    {
        $this->aSubCategory = $aSubCategory;
    }

    /**
     * @return mixed
     */
    public function getAInn()
    {
        return $this->aInn;
    }

    /**
     * @param mixed $aInn
     */
    public function setAInn($aInn)
    {
        $this->aInn = $aInn;
    }

    /**
     * @return mixed
     */
    public function getAOgrn()
    {
        return $this->aOgrn;
    }

    /**
     * @param mixed $aOgrn
     */
    public function setAOgrn($aOgrn)
    {
        $this->aOgrn = $aOgrn;
    }

    /**
     * @return mixed
     */
    public function getAForma()
    {
        return $this->aForma;
    }

    /**
     * @param mixed $aForma
     */
    public function setAForma($aForma)
    {
        $this->aForma = $aForma;
    }

    /**
     * @return mixed
     */
    public function getBTitle()
    {
        return $this->bTitle;
    }

    /**
     * @param mixed $bTitle
     */
    public function setBTitle($bTitle)
    {
        $this->bTitle = $bTitle;
    }

    /**
     * @return mixed
     */
    public function getBNumber()
    {
        return $this->bNumber;
    }

    /**
     * @param mixed $bNumber
     */
    public function setBNumber($bNumber)
    {
        $this->bNumber = $bNumber;
    }

    /**
     * @return mixed
     */
    public function getBRegisterDate()
    {
        return $this->bRegisterDate;
    }

    /**
     * @param mixed $bRegisterDate
     */
    public function setBRegisterDate($bRegisterDate)
    {
        $this->bRegisterDate = $bRegisterDate;
    }

    /**
     * @return mixed
     */
    public function getBInn()
    {
        return $this->bInn;
    }

    /**
     * @param mixed $bInn
     */
    public function setBInn($bInn)
    {
        $this->bInn = $bInn;
    }

    /**
     * @return mixed
     */
    public function getBAdrsCpo()
    {
        return $this->bAdrsCpo;
    }

    /**
     * @param mixed $bAdrsCpo
     */
    public function setBAdrsCpo($bAdrsCpo)
    {
        $this->bAdrsCpo = $bAdrsCpo;
    }

    /**
     * @return mixed
     */
    public function getBAdrsReestr()
    {
        return $this->bAdrsReestr;
    }

    /**
     * @param mixed $bAdrsReestr
     */
    public function setBAdrsReestr($bAdrsReestr)
    {
        $this->bAdrsReestr = $bAdrsReestr;
    }

    /**
     * @return mixed
     */
    public function getBAdrsMail()
    {
        return $this->bAdrsMail;
    }

    /**
     * @param mixed $bAdrsMail
     */
    public function setBAdrsMail($bAdrsMail)
    {
        $this->bAdrsMail = $bAdrsMail;
    }

    /**
     * @return mixed
     */
    public function getBPhone()
    {
        return $this->bPhone;
    }

    /**
     * @param mixed $bPhone
     */
    public function setBPhone($bPhone)
    {
        $this->bPhone = $bPhone;
    }

    /**
     * @return mixed
     */
    public function getBEmail()
    {
        return $this->bEmail;
    }

    /**
     * @param mixed $bEmail
     */
    public function setBEmail($bEmail)
    {
        $this->bEmail = $bEmail;
    }

    /**
     * @return mixed
     */
    public function getBSite()
    {
        return $this->bSite;
    }

    /**
     * @param mixed $bSite
     */
    public function setBSite($bSite)
    {
        $this->bSite = $bSite;
    }

    /**
     * @return mixed
     */
    public function getBSizeFondCpo()
    {
        return $this->bSizeFondCpo;
    }

    /**
     * @param mixed $bSizeFondCpo
     */
    public function setBSizeFondCpo($bSizeFondCpo)
    {
        $this->bSizeFondCpo = $bSizeFondCpo;
    }

    /**
     * @return mixed
     */
    public function getBDateFondCpo()
    {
        return $this->bDateFondCpo;
    }

    /**
     * @param mixed $bDateFondCpo
     */
    public function setBDateFondCpo($bDateFondCpo)
    {
        $this->bDateFondCpo = $bDateFondCpo;
    }

    /**
     * @return mixed
     */
    public function getBSizeFondReestr()
    {
        return $this->bSizeFondReestr;
    }

    /**
     * @param mixed $bSizeFondReestr
     */
    public function setBSizeFondReestr($bSizeFondReestr)
    {
        $this->bSizeFondReestr = $bSizeFondReestr;
    }

    /**
     * @return mixed
     */
    public function getBManager()
    {
        return $this->bManager;
    }

    /**
     * @param mixed $bManager
     */
    public function setBManager($bManager)
    {
        $this->bManager = $bManager;
    }

    /**
     * @return mixed
     */
    public function getBContact()
    {
        return $this->bContact;
    }

    /**
     * @param mixed $bContact
     */
    public function setBContact($bContact)
    {
        $this->bContact = $bContact;
    }

    /**
     * @return mixed
     */
    public function getBCountManager()
    {
        return $this->bCountManager;
    }

    /**
     * @param mixed $bCountManager
     */
    public function setBCountManager($bCountManager)
    {
        $this->bCountManager = $bCountManager;
    }

    /**
     * @return mixed
     */
    public function getCLastName()
    {
        return $this->cLastName;
    }

    /**
     * @param mixed $cLastName
     */
    public function setCLastName($cLastName)
    {
        $this->cLastName = $cLastName;
    }

    /**
     * @return mixed
     */
    public function getCFirstName()
    {
        return $this->cFirstName;
    }

    /**
     * @param mixed $cFirstName
     */
    public function setCFirstName($cFirstName)
    {
        $this->cFirstName = $cFirstName;
    }

    /**
     * @return mixed
     */
    public function getCSurName()
    {
        return $this->cSurName;
    }

    /**
     * @param mixed $cSurName
     */
    public function setCSurName($cSurName)
    {
        $this->cSurName = $cSurName;
    }

    /**
     * @return mixed
     */
    public function getCNumber()
    {
        return $this->cNumber;
    }

    /**
     * @param mixed $cNumber
     */
    public function setCNumber($cNumber)
    {
        $this->cNumber = $cNumber;
    }

    /**
     * @return mixed
     */
    public function getCCpo()
    {
        return $this->cCpo;
    }

    /**
     * @param mixed $cCpo
     */
    public function setCCpo($cCpo)
    {
        $this->cCpo = $cCpo;
    }

    /**
     * @return mixed
     */
    public function getCDate()
    {
        return $this->cDate;
    }

    /**
     * @param mixed $cDate
     */
    public function setCDate($cDate)
    {
        $this->cDate = $cDate;
    }

    /**
     * @return mixed
     */
    public function getDShotTitle()
    {
        return $this->dShotTitle;
    }

    /**
     * @param mixed $dShotTitle
     */
    public function setDShotTitle($dShotTitle)
    {
        $this->dShotTitle = $dShotTitle;
    }

    /**
     * @return mixed
     */
    public function getDFullTitle()
    {
        return $this->dFullTitle;
    }

    /**
     * @param mixed $dFullTitle
     */
    public function setDFullTitle($dFullTitle)
    {
        $this->dFullTitle = $dFullTitle;
    }

    /**
     * @return mixed
     */
    public function getDAdrs()
    {
        return $this->dAdrs;
    }

    /**
     * @param mixed $dAdrs
     */
    public function setDAdrs($dAdrs)
    {
        $this->dAdrs = $dAdrs;
    }

    /**
     * @return mixed
     */
    public function getDPhone()
    {
        return $this->dPhone;
    }

    /**
     * @param mixed $dPhone
     */
    public function setDPhone($dPhone)
    {
        $this->dPhone = $dPhone;
    }

    /**
     * @return mixed
     */
    public function getDRegion()
    {
        return $this->dRegion;
    }

    /**
     * @param mixed $dRegion
     */
    public function setDRegion($dRegion)
    {
        $this->dRegion = $dRegion;
    }

    /**
     * @return mixed
     */
    public function getDInn()
    {
        return $this->dInn;
    }

    /**
     * @param mixed $dInn
     */
    public function setDInn($dInn)
    {
        $this->dInn = $dInn;
    }

    /**
     * @return mixed
     */
    public function getDKpp()
    {
        return $this->dKpp;
    }

    /**
     * @param mixed $dKpp
     */
    public function setDKpp($dKpp)
    {
        $this->dKpp = $dKpp;
    }

    /**
     * @return mixed
     */
    public function getDOgrn()
    {
        return $this->dOgrn;
    }

    /**
     * @param mixed $dOgrn
     */
    public function setDOgrn($dOgrn)
    {
        $this->dOgrn = $dOgrn;
    }

    /**
     * @return mixed
     */
    public function getDOkpo()
    {
        return $this->dOkpo;
    }

    /**
     * @param mixed $dOkpo
     */
    public function setDOkpo($dOkpo)
    {
        $this->dOkpo = $dOkpo;
    }

    /**
     * @return mixed
     */
    public function getDForma()
    {
        return $this->dForma;
    }

    /**
     * @param mixed $dForma
     */
    public function setDForma($dForma)
    {
        $this->dForma = $dForma;
    }

    /**
     * @return mixed
     */
    public function getETitle()
    {
        return $this->eTitle;
    }

    /**
     * @param mixed $eTitle
     */
    public function setETitle($eTitle)
    {
        $this->eTitle = $eTitle;
    }

    /**
     * @return mixed
     */
    public function getESite()
    {
        return $this->eSite;
    }

    /**
     * @param mixed $eSite
     */
    public function setESite($eSite)
    {
        $this->eSite = $eSite;
    }

    /**
     * @return mixed
     */
    public function getEAdrs()
    {
        return $this->eAdrs;
    }

    /**
     * @param mixed $eAdrs
     */
    public function setEAdrs($eAdrs)
    {
        $this->eAdrs = $eAdrs;
    }

    /**
     * @return mixed
     */
    public function getEInn()
    {
        return $this->eInn;
    }

    /**
     * @param mixed $eInn
     */
    public function setEInn($eInn)
    {
        $this->eInn = $eInn;
    }

    /**
     * @return mixed
     */
    public function getEOgrn()
    {
        return $this->eOgrn;
    }

    /**
     * @param mixed $eOgrn
     */
    public function setEOgrn($eOgrn)
    {
        $this->eOgrn = $eOgrn;
    }

    /**
     * @return mixed
     */
    public function getFFio()
    {
        return $this->fFio;
    }

    /**
     * @param mixed $fFio
     */
    public function setFFio($fFio)
    {
        $this->fFio = $fFio;
    }

    /**
     * @return mixed
     */
    public function getFBirthday()
    {
        return $this->fBirthday;
    }

    /**
     * @param mixed $fBirthday
     */
    public function setFBirthday($fBirthday)
    {
        $this->fBirthday = $fBirthday;
    }

    /**
     * @return mixed
     */
    public function getFCountry()
    {
        return $this->fCountry;
    }

    /**
     * @param mixed $fCountry
     */
    public function setFCountry($fCountry)
    {
        $this->fCountry = $fCountry;
    }

    /**
     * @return mixed
     */
    public function getFRegion()
    {
        return $this->fRegion;
    }

    /**
     * @param mixed $fRegion
     */
    public function setFRegion($fRegion)
    {
        $this->fRegion = $fRegion;
    }

    /**
     * @return mixed
     */
    public function getFworkPlace()
    {
        return $this->fworkPlace;
    }

    /**
     * @param mixed $fworkPlace
     */
    public function setFworkPlace($fworkPlace)
    {
        $this->fworkPlace = $fworkPlace;
    }

    /**
     * @return mixed
     */
    public function getFPost()
    {
        return $this->fPost;
    }

    /**
     * @param mixed $fPost
     */
    public function setFPost($fPost)
    {
        $this->fPost = $fPost;
    }

    /**
     * @return mixed
     */
    public function getFSupreme()
    {
        return $this->fSupreme;
    }

    /**
     * @param mixed $fSupreme
     */
    public function setFSupreme($fSupreme)
    {
        $this->fSupreme = $fSupreme;
    }

    /**
     * @return mixed
     */
    public function getFTitleOrgan()
    {
        return $this->fTitleOrgan;
    }

    /**
     * @param mixed $fTitleOrgan
     */
    public function setFTitleOrgan($fTitleOrgan)
    {
        $this->fTitleOrgan = $fTitleOrgan;
    }

    /**
     * @return mixed
     */
    public function getFOffense()
    {
        return $this->fOffense;
    }

    /**
     * @param mixed $fOffense
     */
    public function setFOffense($fOffense)
    {
        $this->fOffense = $fOffense;
    }

    /**
     * @return mixed
     */
    public function getFQualification()
    {
        return $this->fQualification;
    }

    /**
     * @param mixed $fQualification
     */
    public function setFQualification($fQualification)
    {
        $this->fQualification = $fQualification;
    }

    /**
     * @return mixed
     */
    public function getFOffenseDatel()
    {
        return $this->fOffenseDatel;
    }

    /**
     * @param mixed $fOffenseDatel
     */
    public function setFOffenseDatel($fOffenseDatel)
    {
        $this->fOffenseDatel = $fOffenseDatel;
    }

    /**
     * @return mixed
     */
    public function getFIssuedResolutionRegion()
    {
        return $this->fIssuedResolutionRegion;
    }

    /**
     * @param mixed $fIssuedResolutionRegion
     */
    public function setFIssuedResolutionRegion($fIssuedResolutionRegion)
    {
        $this->fIssuedResolutionRegion = $fIssuedResolutionRegion;
    }

    /**
     * @return mixed
     */
    public function getFIssuedResolutionTitle()
    {
        return $this->fIssuedResolutionTitle;
    }

    /**
     * @param mixed $fIssuedResolutionTitle
     */
    public function setFIssuedResolutionTitle($fIssuedResolutionTitle)
    {
        $this->fIssuedResolutionTitle = $fIssuedResolutionTitle;
    }

    /**
     * @return mixed
     */
    public function getFIssuedDate()
    {
        return $this->fIssuedDate;
    }

    /**
     * @param mixed $fIssuedDate
     */
    public function setFIssuedDate($fIssuedDate)
    {
        $this->fIssuedDate = $fIssuedDate;
    }

    /**
     * @return mixed
     */
    public function getFDisqualification()
    {
        return $this->fDisqualification;
    }

    /**
     * @param mixed $fDisqualification
     */
    public function setFDisqualification($fDisqualification)
    {
        $this->fDisqualification = $fDisqualification;
    }

    /**
     * @return mixed
     */
    public function getFDateStart()
    {
        return $this->fDateStart;
    }

    /**
     * @param mixed $fDateStart
     */
    public function setFDateStart($fDateStart)
    {
        $this->fDateStart = $fDateStart;
    }

    /**
     * @return mixed
     */
    public function getFDateEnd()
    {
        return $this->fDateEnd;
    }

    /**
     * @param mixed $fDateEnd
     */
    public function setFDateEnd($fDateEnd)
    {
        $this->fDateEnd = $fDateEnd;
    }

    /**
     * @return mixed
     */
    public function getFNumber()
    {
        return $this->fNumber;
    }

    /**
     * @param mixed $fNumber
     */
    public function setFNumber($fNumber)
    {
        $this->fNumber = $fNumber;
    }

    /**
     * @return mixed
     */
    public function getCInn()
    {
        return $this->cInn;
    }

    /**
     * @param mixed $cInn
     */
    public function setCInn($cInn)
    {
        $this->cInn = $cInn;
    }

    /**
     * @return mixed
     */
    public function getFOffenseDate()
    {
        return $this->fOffenseDate;
    }

    /**
     * @param mixed $fOffenseDate
     */
    public function setFOffenseDate($fOffenseDate)
    {
        $this->fOffenseDate = $fOffenseDate;
    }

    /**
     * @return mixed
     */
    public function getEFullTitle()
    {
        return $this->eFullTitle;
    }

    /**
     * @param mixed $eFullTitle
     */
    public function setEFullTitle($eFullTitle)
    {
        $this->eFullTitle = $eFullTitle;
    }


}