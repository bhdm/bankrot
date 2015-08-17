<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Iphp\FileStoreBundle\Mapping\Annotation as FileStore;

/**
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @FileStore\Uploadable
 */
class Registry extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="registries")
     */
    protected $user;

    /**
     * @ORM\Column(type="string")
     */
    protected $lotTitle;

    /**
     * @ORM\Column(type="string")
     */
    protected $lotLink;

    /**
     * @ORM\Column(type="text")
     */
    protected $body;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $comment;

    public function __toString(){
        return $this->lotTitle;
    }

    public function __construct(){
        $this->enabled = false;
    }

    /**
     * @Assert\File( maxSize="3M")
     * @FileStore\UploadableField(mapping="arbitrationFiles")
     * @ORM\Column(type="array", nullable=true)
     */
    protected $file;

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
    public function getLotTitle()
    {
        return $this->lotTitle;
    }

    /**
     * @param mixed $lotTitle
     */
    public function setLotTitle($lotTitle)
    {
        $this->lotTitle = $lotTitle;
    }

    /**
     * @return mixed
     */
    public function getLotLink()
    {
        return $this->lotLink;
    }

    /**
     * @param mixed $lotLink
     */
    public function setLotLink($lotLink)
    {
        $this->lotLink = $lotLink;
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
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function setEnabled($enabled = false){
        $this->enabled = $enabled;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }


}