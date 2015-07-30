<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Iphp\FileStoreBundle\Mapping\Annotation as FileStore;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @FileStore\Uploadable
 */
class Arbitration extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="arbitrations")
     */
    protected $user;

    /**
     * @ORM\Column(type="string")
     */
    protected $fio;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cpo;

    /**
     * @ORM\Column(type="text")
     */
    protected $body;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $comment;

    /**
     * @Assert\File( maxSize="3M")
     * @FileStore\UploadableField(mapping="arbitrationFiles")
     * @ORM\Column(type="array", nullable=true)
     */
    protected $file;

    public function __toString(){
        return $this->fio;
    }

    public function __construct(){
        $this->enabled = false;
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

    public function setEnabled($enabled = false){
        $this->enabled = $enabled;
    }

}