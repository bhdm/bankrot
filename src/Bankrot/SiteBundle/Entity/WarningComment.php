<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class WarningComment extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Registry", inversedBy="comments")
     */
    protected $registry;

    /**
     * @ORM\ManyToOne(targetEntity="Arbitration", inversedBy="comments")
     */
    protected $arbitration;


    /**
     * @ORM\Column(type="text")
     */
    protected $body;

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

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getRegistry()
    {
        return $this->registry;
    }

    /**
     * @param mixed $registry
     */
    public function setRegistry($registry)
    {
        $this->registry = $registry;
    }

    /**
     * @return mixed
     */
    public function getArbitration()
    {
        return $this->arbitration;
    }

    /**
     * @param mixed $arbitration
     */
    public function setArbitration($arbitration)
    {
        $this->arbitration = $arbitration;
    }


}