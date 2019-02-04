<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Images;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Aboutcompany
 *
 * @ORM\Table(name="aboutcompany", indexes={@ORM\Index(name="fk_AboutCompany_Images1_idx", columns={"ImageId"})})
 * @ORM\Entity
 */
class Aboutcompany
{
    /**
     * @var string
     *
     * @ORM\Column(name="AboutTitle", type="string", length=50, nullable=false)
     */
    private $abouttitle;

    /**
     * @var string
     *
     * @ORM\Column(name="AboutDescription", type="string", length=255, nullable=false)
     */
    private $aboutdescription;

    /**
     * @var \DateTime
     *
     *
     * @ORM\Column(name="AdditionDate", type="datetime", nullable=false)
     */
    private $additiondate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="UpdatedAt", type="datetime", nullable=true)
     */
    private $updatedat;

    /**
     * @var integer
     *
     * @ORM\Column(name="AboutId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $aboutid;

    /**
     * @var Images
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Images")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ImageId", referencedColumnName="ImageId")
     * })
     */
    private $imageid;

    /**
     * @var string $image
     * @Assert\File( maxSize = "1024k", mimeTypesMessage = "Please upload a valid Image")
     */
    private $image2;

    /**
     * Aboutcompany constructor.
     */
    public function __construct()
    {
        $this->additiondate = new \DateTime();
    }

    /**
     * Set abouttitle
     *
     * @param string $abouttitle
     *
     * @return Aboutcompany
     */
    public function setAbouttitle($abouttitle)
    {
        $this->abouttitle = $abouttitle;

        return $this;
    }

    /**
     * Get abouttitle
     *
     * @return string
     */
    public function getAbouttitle()
    {
        return $this->abouttitle;
    }

    /**
     * Set aboutdescription
     *
     * @param string $aboutdescription
     *
     * @return Aboutcompany
     */
    public function setAboutdescription($aboutdescription)
    {
        $this->aboutdescription = $aboutdescription;

        return $this;
    }

    /**
     * Get aboutdescription
     *
     * @return string
     */
    public function getAboutdescription()
    {
        return $this->aboutdescription;
    }

    /**
     * Set additiondate
     *
     * @param \DateTime $additiondate
     *
     * @return Aboutcompany
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
     * @return Aboutcompany
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
     * Get aboutid
     *
     * @return integer
     */
    public function getAboutid()
    {
        return $this->aboutid;
    }

    /**
     * Set imageid
     *
     * @param Images $imageid
     *
     * @return Aboutcompany
     */
    public function setImageid(Images $imageid = null)
    {
        $this->imageid = $imageid;

        return $this;
    }

    /**
     * Get imageid
     *
     * @return Images
     */
    public function getImageid()
    {
        return $this->imageid;
    }

    /**
     * @return string
     */
    public function getImage2()
    {
        return $this->image2;
    }

    /**
     * @param string $image2
     */
    public function setImage2($image2)
    {
        $this->image2 = $image2;
    }

}
