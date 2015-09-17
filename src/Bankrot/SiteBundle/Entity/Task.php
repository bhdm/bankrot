<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Bankrot\SiteBundle\Entity\TaskRepository")
 */
class Task extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="Bankrot\SiteBundle\Entity\User", inversedBy="tasks")
     */
    protected $user;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(name="dateAt", type="datetime", nullable=true)
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="Bankrot\SiteBundle\Entity\Lot", inversedBy="tasks")
     */
    protected $lot;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isSuccess = false;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getLot()
    {
        return $this->lot;
    }

    /**
     * @param mixed $lot
     */
    public function setLot($lot)
    {
        $this->lot = $lot;
    }

    /**
     * @return mixed
     */
    public function getIsSuccess()
    {
        return $this->isSuccess;
    }

    /**
     * @param mixed $isSuccess
     */
    public function setIsSuccess($isSuccess)
    {
        $this->isSuccess = $isSuccess;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }



}