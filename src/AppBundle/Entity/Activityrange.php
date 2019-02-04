<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activityrange
 *
 * @ORM\Table(name="activityrange", indexes={@ORM\Index(name="fk_ActivityRange_Images1_idx", columns={"ImageId"})})
 * @ORM\Entity
 */
class Activityrange
{
    /**
     * @var string
     *
     * @ORM\Column(name="ActivityTitle", type="string", length=50, nullable=false)
     */
    private $activitytitle;

    /**
     * @var string
     *
     * @ORM\Column(name="ActivityDescription", type="string", length=255, nullable=false)
     */
    private $activitydescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="AdditionDate", type="datetime", nullable=false)
     */
    private $additiondate = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="UpdatedAt", type="datetime", nullable=true)
     */
    private $updatedat;

    /**
     * @var integer
     *
     * @ORM\Column(name="ActivityRangeId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $activityrangeid;

    /**
     * @var \AppBundle\Entity\Images
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Images")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ImageId", referencedColumnName="ImageId")
     * })
     */
    private $imageid;

    /**
     * Activityrange constructor.
     */
    public function __construct()
    {
        $this->additiondate = new \DateTime();
    }

    /**
     * Set activitytitle
     *
     * @param string $activitytitle
     *
     * @return Activityrange
     */
    public function setActivitytitle($activitytitle)
    {
        $this->activitytitle = $activitytitle;

        return $this;
    }

    /**
     * Get activitytitle
     *
     * @return string
     */
    public function getActivitytitle()
    {
        return $this->activitytitle;
    }

    /**
     * Set activitydescription
     *
     * @param string $activitydescription
     *
     * @return Activityrange
     */
    public function setActivitydescription($activitydescription)
    {
        $this->activitydescription = $activitydescription;

        return $this;
    }

    /**
     * Get activitydescription
     *
     * @return string
     */
    public function getActivitydescription()
    {
        return $this->activitydescription;
    }

    /**
     * Set additiondate
     *
     * @param \DateTime $additiondate
     *
     * @return Activityrange
     */
    public function setAdditiondate($additiondate)
    {
        $this->additiondate = $additiondate;

        return $this;
    }

    /**
     * Get additiondate
     *
     * @return \DateTime
     */
    public function getAdditiondate()
    {
        return $this->additiondate;
    }

    /**
     * Set updatedat
     *
     * @param \DateTime $updatedat
     *
     * @return Activityrange
     */
    public function setUpdatedat($updatedat)
    {
        $this->updatedat = $updatedat;

        return $this;
    }

    /**
     * Get updatedat
     *
     * @return \DateTime
     */
    public function getUpdatedat()
    {
        return $this->updatedat;
    }

    /**
     * Get activityrangeid
     *
     * @return integer
     */
    public function getActivityrangeid()
    {
        return $this->activityrangeid;
    }

    /**
     * Set imageid
     *
     * @param \AppBundle\Entity\Images $imageid
     *
     * @return Activityrange
     */
    public function setImageid(\AppBundle\Entity\Images $imageid = null)
    {
        $this->imageid = $imageid;

        return $this;
    }

    /**
     * Get imageid
     *
     * @return \AppBundle\Entity\Images
     */
    public function getImageid()
    {
        return $this->imageid;
    }
}
