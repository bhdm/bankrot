<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="lotPhotos")
 */
class LotPhoto extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="Lot", inversedBy="photos")
     */
    protected $lot;

    /**
     * @ORM\Column(type="array")
     */
    protected $photo;

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
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }


}
