<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Userroutes
 *
 * @ORM\Table(name="userroutes", indexes={@ORM\Index(name="fk_UserRoutes_Users1_idx", columns={"UserId"})})
 * @ORM\Entity
 */
class Userroutes
{
    /**
     * @var string
     *
     * @ORM\Column(name="RouteName", type="string", length=50, nullable=false)
     */
    private $routename;

    /**
     * @var integer
     *
     * @ORM\Column(name="UserRouteId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userrouteid;

    /**
     * @var \AppBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="UserId", referencedColumnName="UserId")
     * })
     */
    private $userid;



    /**
     * Set routename
     *
     * @param string $routename
     *
     * @return Userroutes
     */
    public function setRoutename($routename)
    {
        $this->routename = $routename;

        return $this;
    }

    /**
     * Get routename
     *
     * @return string
     */
    public function getRoutename()
    {
        return $this->routename;
    }

    /**
     * Get userrouteid
     *
     * @return integer
     */
    public function getUserrouteid()
    {
        return $this->userrouteid;
    }

    /**
     * Set userid
     *
     * @param \AppBundle\Entity\Users $userid
     *
     * @return Userroutes
     */
    public function setUserid(\AppBundle\Entity\Users $userid = null)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return \AppBundle\Entity\Users
     */
    public function getUserid()
    {
        return $this->userid;
    }
}
