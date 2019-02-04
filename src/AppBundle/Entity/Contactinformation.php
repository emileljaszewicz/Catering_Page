<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contactinformation
 *
 * @ORM\Table(name="contactinformation")
 * @ORM\Entity
 */
class Contactinformation
{
    /**
     * @var string
     *
     * @ORM\Column(name="ContactPosition", type="string", length=20, nullable=false)
     */
    private $contactposition;

    /**
     * @var string
     *
     * @ORM\Column(name="ContactDetails", type="string", length=50, nullable=false)
     */
    private $contactdetails;

    /**
     * @var integer
     *
     * @ORM\Column(name="PositionId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $positionid;



    /**
     * Set contactposition
     *
     * @param string $contactposition
     *
     * @return Contactinformation
     */
    public function setContactposition($contactposition)
    {
        $this->contactposition = $contactposition;

        return $this;
    }

    /**
     * Get contactposition
     *
     * @return string
     */
    public function getContactposition()
    {
        return $this->contactposition;
    }

    /**
     * Set contactdetails
     *
     * @param string $contactdetails
     *
     * @return Contactinformation
     */
    public function setContactdetails($contactdetails)
    {
        $this->contactdetails = $contactdetails;

        return $this;
    }

    /**
     * Get contactdetails
     *
     * @return string
     */
    public function getContactdetails()
    {
        return $this->contactdetails;
    }

    /**
     * Get positionid
     *
     * @return integer
     */
    public function getPositionid()
    {
        return $this->positionid;
    }
}
