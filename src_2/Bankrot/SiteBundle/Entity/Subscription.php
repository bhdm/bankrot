<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Subscription extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="subscriptions")
     */
    protected $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $count;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $price;

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
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }


}