<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Table(name="news", indexes={@ORM\Index(name="fk_News_Images1_idx", columns={"ImageId"})})
 * @ORM\Entity
 */
class News
{
    /**
     * @var string
     *
     * @ORM\Column(name="NewsTitle", type="string", length=50, nullable=false)
     */
    private $newstitle;

    /**
     * @var string
     *
     * @ORM\Column(name="NewsDescription", type="string", length=255, nullable=false)
     */
    private $newsdescription;

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
     * @ORM\Column(name="NewsId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $newsid;

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
     * News constructor.
     */
    public function __construct()
    {
        $this->additiondate = new \DateTime();
    }
    /**
     * Set newstitle
     *
     * @param string $newstitle
     *
     * @return News
     */
    public function setNewstitle($newstitle)
    {
        $this->newstitle = $newstitle;

        return $this;
    }

    /**
     * Get newstitle
     *
     * @return string
     */
    public function getNewstitle()
    {
        return $this->newstitle;
    }

    /**
     * Set newsdescription
     *
     * @param string $newsdescription
     *
     * @return News
     */
    public function setNewsdescription($newsdescription)
    {
        $this->newsdescription = $newsdescription;

        return $this;
    }

    /**
     * Get newsdescription
     *
     * @return string
     */
    public function getNewsdescription()
    {
        return $this->newsdescription;
    }

    /**
     * Set additiondate
     *
     * @param \DateTime $additiondate
     *
     * @return News
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
     * @return News
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
     * Get newsid
     *
     * @return integer
     */
    public function getNewsid()
    {
        return $this->newsid;
    }

    /**
     * Set imageid
     *
     * @param \AppBundle\Entity\Images $imageid
     *
     * @return News
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
