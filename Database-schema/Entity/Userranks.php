<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Userranks
 *
 * @ORM\Table(name="userranks", uniqueConstraints={@ORM\UniqueConstraint(name="RankName_UNIQUE", columns={"RankName"})})
 * @ORM\Entity
 */
class Userranks
{
    /**
     * @var string
     *
     * @ORM\Column(name="RankName", type="string", length=50, nullable=false)
     */
    private $rankname;

    /**
     * @var integer
     *
     * @ORM\Column(name="RankId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $rankid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Pageroutes", mappedBy="rankid")
     */
    private $routeid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->routeid = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function getRankname()
    {
        return $this->rankname;
    }

    /**
     * @param string $rankname
     */
    public function setRankname(string $rankname)
    {
        $this->rankname = $rankname;
    }

    /**
     * @return int
     */
    public function getRankid()
    {
        return $this->rankid;
    }

    /**
     * @param int $rankid
     */
    public function setRankid(int $rankid)
    {
        $this->rankid = $rankid;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRouteid()
    {
        return $this->routeid;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $routeid
     */
    public function setRouteid(\Doctrine\Common\Collections\Collection $routeid)
    {
        $this->routeid = $routeid;
    }

}

