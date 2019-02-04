<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use  AppBundle\Entity\Users;

/**
 * Pageroutes
 *
 * @ORM\Table(name="pageroutes")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PageroutesRepository")
 */
class Pageroutes
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
     * @ORM\Column(name="RouteId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $routeid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Userranks", inversedBy="routeid")
     * @ORM\JoinTable(name="rankroutes",
     *   joinColumns={
     *     @ORM\JoinColumn(name="RouteId", referencedColumnName="RouteId")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="RankId", referencedColumnName="RankId")
     *   }
     * )
     */
    private $rankid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Users", mappedBy="routeid")
     */
    private $userid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rankid = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function getRoutename()
    {
        return $this->routename;
    }

    /**
     * @param string $routename
     */
    public function setRoutename(string $routename)
    {
        $this->routename = $routename;
    }

    /**
     * @return int
     */
    public function getRouteid()
    {
        return $this->routeid;
    }

    /**
     * @param int $routeid
     */
    public function setRouteid(int $routeid)
    {
        $this->routeid = $routeid;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRankid()
    {
        return $this->rankid;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $rankid
     */
    public function setRankid(Userranks $rankid)
    {
        $this->rankid[] = $rankid;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

}

