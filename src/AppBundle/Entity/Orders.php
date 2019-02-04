<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders", indexes={@ORM\Index(name="fk_Orders_Meals1_idx", columns={"MealId"})})
 * @ORM\Entity
 */
class Orders
{
    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Surname", type="string", length=50, nullable=false)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="Adress", type="string", length=50, nullable=false)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="Phone", type="string", length=6, nullable=false)
     */
    private $phone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="OrderDate", type="datetime", nullable=false)
     */
    private $orderdate = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="Status", type="string", length=20, nullable=true)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="OrderId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $orderid;

    /**
     * @var \AppBundle\Entity\Meals
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Meals")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="MealId", referencedColumnName="MealId")
     * })
     */
    private $mealid;

    /**
     * @var string
     *
     * @ORM\Column(name="AdditionalInfo", type="string", length=45, nullable=true)
     */
    private $additionalinfo;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Orders
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return Orders
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return Orders
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Orders
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set orderdate
     *
     * @param \DateTime $orderdate
     *
     * @return Orders
     */
    public function setOrderdate($orderdate)
    {
        $this->orderdate = $orderdate;

        return $this;
    }

    /**
     * Get orderdate
     *
     * @return \DateTime
     */
    public function getOrderdate()
    {
        return $this->orderdate;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Orders
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get orderid
     *
     * @return integer
     */
    public function getOrderid()
    {
        return $this->orderid;
    }

    /**
     * Set mealid
     *
     * @param \AppBundle\Entity\Meals $mealid
     *
     * @return Orders
     */
    public function setMealid(\AppBundle\Entity\Meals $mealid = null)
    {
        $this->mealid = $mealid;

        return $this;
    }

    /**
     * Get mealid
     *
     * @return \AppBundle\Entity\Meals
     */
    public function getMealid()
    {
        return $this->mealid;
    }

    /**
     * @return string
     */
    public function getAdditionalinfo()
    {
        return $this->additionalinfo;
    }

    /**
     * @param string $additionalinfo
     */
    public function setAdditionalinfo(string $additionalinfo)
    {
        $this->additionalinfo = $additionalinfo;
    }

}
