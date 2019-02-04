<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menucategories
 *
 *@ORM\Table(name="menucategories", indexes={@ORM\Index(name="fk_MenuCategories_Images1_idx", columns={"ImageId"})})
 * @ORM\Entity
 */
class Menucategories
{
    /**
     * @var string
     *
     * @ORM\Column(name="CategoryName", type="string", length=50, nullable=false)
     */
    private $categoryname;

    /**
     * @var string
     *
     * @ORM\Column(name="CategoryDescription", type="string", length=255, nullable=false)
     */
    private $categorydescription;

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
     * @ORM\Column(name="CategoryId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $categoryid;

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
     * Menucategories constructor.
     */
    public function __construct()
    {
        $this->additiondate = new \DateTime();
    }

    /**
     * Set categoryname
     *
     * @param string $categoryname
     *
     * @return Menucategories
     */
    public function setCategoryname($categoryname)
    {
        $this->categoryname = $categoryname;

        return $this;
    }

    /**
     * Get categoryname
     *
     * @return string
     */
    public function getCategoryname()
    {
        return $this->categoryname;
    }

    /**
     * Set categorydescription
     *
     * @param string $categorydescription
     *
     * @return Menucategories
     */
    public function setCategorydescription($categorydescription)
    {
        $this->categorydescription = $categorydescription;

        return $this;
    }

    /**
     * Get categorydescription
     *
     * @return string
     */
    public function getCategorydescription()
    {
        return $this->categorydescription;
    }

    /**
     * Set additiondate
     *
     * @param \DateTime $additiondate
     *
     * @return Menucategories
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
     * @return Menucategories
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
     * Get categoryid
     *
     * @return integer
     */
    public function getCategoryid()
    {
        return $this->categoryid;
    }

    /**
     * Set imageid
     *
     * @param \AppBundle\Entity\Images $imageid
     *
     * @return Menucategories
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
