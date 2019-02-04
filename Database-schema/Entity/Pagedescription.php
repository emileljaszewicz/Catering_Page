<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pagedescription
 *
 * @ORM\Table(name="pagedescription")
 * @ORM\Entity
 */
class Pagedescription
{
    /**
     * @var string
     *
     * @ORM\Column(name="Title", type="string", length=50, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=255, nullable=false)
     */
    private $description;

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
     * @var string
     *
     * @ORM\Column(name="RouteName", type="string", length=50, nullable=false)
     */
    private $routename;

    /**
     * @var integer
     *
     * @ORM\Column(name="DescriptionId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $descriptionid;


    /**
     * Pagedescription constructor.
     */
    public function __construct()
    {
        $this->additiondate = new \DateTime();
    }


    /**
     * Set title
     *
     * @param string $title
     *
     * @return Pagedescription
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Pagedescription
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set additiondate
     *
     * @param \DateTime $additiondate
     *
     * @return Pagedescription
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
     * @return Pagedescription
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
     * Set routename
     *
     * @param string $routename
     *
     * @return Pagedescription
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
     * Get descriptionid
     *
     * @return integer
     */
    public function getDescriptionid()
    {
        return $this->descriptionid;
    }
}
