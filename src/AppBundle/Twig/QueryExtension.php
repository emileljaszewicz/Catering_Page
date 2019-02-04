<?php
namespace AppBundle\Twig;


use AppBundle\Entity\Meals;
use Doctrine\ORM\EntityManagerInterface;

class QueryExtension extends \Twig_Extension
{
    protected $doctrine;
    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter("countOFMeals", [$this, "countMeals"]),
        );
    }

    public function countMeals($menuCategoryId)
    {

        $menuCategoriesRepository = $this->doctrine->getRepository(Meals::class);
        $categoryMeals = $menuCategoriesRepository->findBy(["categoryid" => $menuCategoryId]);

        return  count($categoryMeals);
    }
}