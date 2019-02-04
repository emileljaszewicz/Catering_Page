<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Messagescustomers
 *
 * @ORM\Table(name="messagescustomers")
 * @ORM\Entity
 */
class Messagescustomers
{
    /**
     * @var string
     *
     * @ORM\Column(name="MessageTitle", type="string", length=50, nullable=false)
     */
    private $messagetitle;

    /**
     * @var string
     *
     * @ORM\Column(name="MessageDescription", type="string", length=255, nullable=false)
     */
    private $messagedescription;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CreatedAt", type="datetime", nullable=false)
     */
    private $createdat = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="Received", type="integer", nullable=true)
     */
    private $received;

    /**
     * @var integer
     *
     * @ORM\Column(name="MessageId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $messageid;
    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=50, nullable=false)
     */
    private $name;


    /**
     * Set messagetitle
     *
     * @param string $messagetitle
     *
     * @return Messagescustomers
     */
    public function setMessagetitle($messagetitle)
    {
        $this->messagetitle = $messagetitle;

        return $this;
    }

    /**
     * Get messagetitle
     *
     * @return string
     */
    public function getMessagetitle()
    {
        return $this->messagetitle;
    }

    /**
     * Set messagedescription
     *
     * @param string $messagedescription
     *
     * @return Messagescustomers
     */
    public function setMessagedescription($messagedescription)
    {
        $this->messagedescription = $messagedescription;

        return $this;
    }

    /**
     * Get messagedescription
     *
     * @return string
     */
    public function getMessagedescription()
    {
        return $this->messagedescription;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Messagescustomers
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set createdat
     *
     * @param \DateTime $createdat
     *
     * @return Messagescustomers
     */
    public function setCreatedat($createdat)
    {
        $this->createdat = $createdat;

        return $this;
    }

    /**
     * Get createdat
     *
     * @return \DateTime
     */
    public function getCreatedat()
    {
        return $this->createdat;
    }

    /**
     * Set received
     *
     * @param integer $received
     *
     * @return Messagescustomers
     */
    public function setReceived($received)
    {
        $this->received = $received;

        return $this;
    }

    /**
     * Get received
     *
     * @return integer
     */
    public function getReceived()
    {
        return $this->received;
    }

    /**
     * Get messageid
     *
     * @return integer
     */
    public function getMessageid()
    {
        return $this->messageid;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

}
