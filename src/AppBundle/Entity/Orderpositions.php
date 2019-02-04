<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orderpositions
 *
 * @ORM\Table(name="orderpositions", indexes={@ORM\Index(name="fk_orderpositions_orders1_idx", columns={"OrderId"}), @ORM\Index(name="fk_orderpositions_meals1_idx", columns={"MealId"})})
 * @ORM\Entity
 */
class Orderpositions
{
    /**
     * @var integer
     *
     * @ORM\Column(name="OrderPositionId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $orderpositionid;

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
     * @var \AppBundle\Entity\Orders
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="OrderId", referencedColumnName="OrderId")
     * })
     */
    private $orderid;

    /**
     * @return int
     */
    public function getOrderpositionid()
    {
        return $this->orderpositionid;
    }

    /**
     * @param int $orderpositionid
     */
    public function setOrderpositionid(int $orderpositionid)
    {
        $this->orderpositionid = $orderpositionid;
    }

    /**
     * @return Meals
     */
    public function getMealid()
    {
        return $this->mealid;
    }

    /**
     * @param Meals $mealid
     */
    public function setMealid(Meals $mealid)
    {
        $this->mealid = $mealid;
    }

    /**
     * @return Orders
     */
    public function getOrderid()
    {
        return $this->orderid;
    }

    /**
     * @param Orders $orderid
     */
    public function setOrderid(Orders $orderid)
    {
        $this->orderid = $orderid;
    }


}

