<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Meals
 *
 * @ORM\Table(name="meals", indexes={@ORM\Index(name="fk_Meals_Images1_idx", columns={"ImageId"}), @ORM\Index(name="fk_Meals_MenuCategories1_idx", columns={"CategoryId"})})
 * @ORM\Entity
 */
class Meals
{
    /**
     * @var string
     *
     * @ORM\Column(name="MealName", type="string", length=50, nullable=false)
     */
    private $mealname;

    /**
     * @var string
     *
     * @ORM\Column(name="MealDescription", type="string", length=255, nullable=false)
     */
    private $mealdescription;

    /**
     * @var string
     *
     * @ORM\Column(name="Price", type="decimal", precision=2, scale=0, nullable=false)
     */
    private $price;

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
     * @ORM\Column(name="MealId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $mealid;

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
     * @var \AppBundle\Entity\Menucategories
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Menucategories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CategoryId", referencedColumnName="CategoryId")
     * })
     */
    private $categoryid;


    /**
     * Meals constructor.
     */
    public function __construct()
    {
        $this->additiondate = new \DateTime();
    }
    /**
     * Set mealname
     *
     * @param string $mealname
     *
     * @return Meals
     */
    public function setMealname($mealname)
    {
        $this->mealname = $mealname;

        return $this;
    }

    /**
     * Get mealname
     *
     * @return string
     */
    public function getMealname()
    {
        return $this->mealname;
    }

    /**
     * Set mealdescription
     *
     * @param string $mealdescription
     *
     * @return Meals
     */
    public function setMealdescription($mealdescription)
    {
        $this->mealdescription = $mealdescription;

        return $this;
    }

    /**
     * Get mealdescription
     *
     * @return string
     */
    public function getMealdescription()
    {
        return $this->mealdescription;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Meals
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set additiondate
     *
     * @param \DateTime $additiondate
     *
     * @return Meals
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
     * @return Meals
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
     * Get mealid
     *
     * @return integer
     */
    public function getMealid()
    {
        return $this->mealid;
    }

    /**
     * Set imageid
     *
     * @param \AppBundle\Entity\Images $imageid
     *
     * @return Meals
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

    /**
     * Set categoryid
     *
     * @param \AppBundle\Entity\Menucategories $categoryid
     *
     * @return Meals
     */
    public function setCategoryid(\AppBundle\Entity\Menucategories $categoryid = null)
    {
        $this->categoryid = $categoryid;

        return $this;
    }

    /**
     * Get categoryid
     *
     * @return \AppBundle\Entity\Menucategories
     */
    public function getCategoryid()
    {
        return $this->categoryid;
    }
}
