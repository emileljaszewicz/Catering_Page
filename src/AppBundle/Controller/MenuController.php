<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 2018-06-05
 * Time: 19:25
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Meals;
use AppBundle\Entity\Menucategories;
use AppBundle\Entity\Orderpositions;
use AppBundle\Entity\Orders;
use AppBundle\Form\OrderFormType;
use AppBundle\Service\ShoppingBasketSrvice;
use http\Env\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Serializer\Encoder\JsonEncode;

class MenuController extends Controller
{
    private $shoppingBasket = null;
    public function __construct()
    {
        $this->shoppingBasket = new ShoppingBasketSrvice();
        $this->shoppingBasket->initShoppingBasket();
    }

    /**
     * @Route("/categories", name="categories")
     */
    public function showCategoriesAction()
    {

        $menuCategories = $this->getDoctrine()->getRepository(Menucategories::class);
        $query = $menuCategories->createQueryBuilder('mealCategory')
            ->select('mealCategory')
            ->getQuery();
        $menuCategories = $query->getResult();

        return $this->render("Catering/categories.html.twig", ["menuCategories" => $menuCategories]);
    }

    /**
     * @Route("/categories/show/{id}", name="categories_show")
     * @param Meals $meals
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showCategoryAction(Menucategories $menuCategories)
    {
        $buttonsCollection = [];
        $meals = $this->getDoctrine()->getRepository(Meals::class)->findBy(["categoryid" => $menuCategories]);
        $orderform = $this->createFormBuilder()
            ->add('content',TextType::class, ["label" => "podaj ilość"])
            ->add('save',ButtonType::class, ["label" => "Zapisz"])
            ->add('close',ButtonType::class, ["label" => "Anuluj"])
            ->getForm();
        foreach ($meals as $categoryMeal){
            $deleteButton = $this->createFormBuilder()
                ->add("orderbutton", SubmitType::class, ["label" => "zamów"])
                ->getForm();
            $buttonsCollection[$categoryMeal->getMealid()] = $deleteButton->createView();
        }
        return $this->render("Catering/category.html.twig", [
            "categoryMeals" => $meals,
            "categoryInfo" => $menuCategories,
            "buttons" => $buttonsCollection,
            "orderForm" => $orderform->createView(),
        ]);
    }

    /**
     * @Route("/shoppingbasket/add/{menucategories}/product/{meals}", name="shoppingbasket_product_add")
     */
    public function addProductToBasketAction(Menucategories $menucategories, Meals $meals){
        $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        //$shoppingBasket->addProduct($menucategories, $meals);
        $this->shoppingBasket->changeProductAmount($meals, $request->get('orderAmount'));

        return new \Symfony\Component\HttpFoundation\Response(
            json_encode(['amount' => $this->shoppingBasket->getProductsAmount()])
        );
    }

    /**
     * @Route("/shoppingbasket/get/{menucategories}/productamount/{meals}", name="shoppingbasket_productamount_get")
     */
    public function getProductAmountAction(Menucategories $menucategories, Meals $meals){

        $productAmount = $this->shoppingBasket->getProductAmount($menucategories, $meals);
        $productAmount = json_encode(['amount' => $productAmount, 'url' => $this->generateUrl('shoppingbasket_product_add', ['menucategories' => $menucategories->getCategoryid(), 'meals' => $meals->getMealid()])]);
        return new \Symfony\Component\HttpFoundation\Response(
            $productAmount
        );
    }
    /**
     * @Route("/shoppingbasket/order/show", name="shoppingbasket_order_show")
     */
    public function showOrderAction(\Symfony\Component\HttpFoundation\Request $request){

        if(sizeof($this->shoppingBasket->getAllProducts()) > 0) {
            $orders = new Orders();
            $data = $request::createFromGlobals();
            $changeAmountForm = $this->createFormBuilder()
                ->add('content', TextType::class, ["label" => "podaj ilość"])
                ->add('save', ButtonType::class, ["label" => "Zapisz"])
                ->add('close', ButtonType::class, ["label" => "Anuluj"])
                ->getForm();
            $orderForm = $this->createForm(OrderFormType::class, $orders);

            $finaliseButton = $this->createFormBuilder()
                ->add('finalizeForm', ButtonType::class, ["label" => "Złóż zamówienie"])
                ->getForm();

            $orderForm->handleRequest($request);

            if (($this->shoppingBasket->getProductsAmount() > 0) && $request->isMethod('post')) {
                if (empty($request->get('action'))) {
                    $this->shoppingBasket->addOwnerData($orders);
                }
                if ($request->get('action') == 'save') {
                    return $this->redirectToRoute("shoppingbasket_transaction_finalise");
                }
                if ($request->get('action') == 'deleteOrder') {
                    return $this->redirectToRoute("shoppingbasket_transaction_delete");
                }

                return new \Symfony\Component\HttpFoundation\Response(
                    var_dump($data->get('action'))
                );


            }

            foreach ($this->shoppingBasket->getAllProducts() as $categoryId => $basketProducts) {
                foreach ($basketProducts as $productId => $productDetails) {
                    $deleteButton = $this->createFormBuilder()
                        ->add("orderbutton", SubmitType::class, ["label" => "edytuj"])
                        ->getForm();
                    $buttonsCollection[$productId] = $deleteButton->createView();
                }
            }
            $orderedProducts = $this->shoppingBasket->getAllProducts();

            return $this->render("Catering/shoppingbasket.html.twig", [
                "basketProducts" => $orderedProducts,
                "changeAmountForm" => $changeAmountForm->createView(),
                "openFinalizeForm" => $finaliseButton->createView(),
                "buttons" => $buttonsCollection,
                "orderForm" => $orderForm->createView(),
            ]);
        }
        else{
            return $this->redirectToRoute("homepage");
        }
    }

    /**
     * @Route("/shoppingbasket/transaction/finalise", name="shoppingbasket_transaction_finalise")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function finaliseShoppingAction(){
        $ownerData = $this->shoppingBasket->getOwnerData();
        $orderedProducts = $this->shoppingBasket->getAllProducts();
        $orderPositions = new Orderpositions();

        $eM = $this->getDoctrine()->getManager();
        $eM->persist($ownerData);
        $eM->flush();


        foreach ($orderedProducts as $productCategory => $productData){
            foreach ($productData as $product) {
                $eM2 = $this->getDoctrine()->getManager();
                $productOb = unserialize($product[0]);
                $orderPositions->setMealid($productOb);
                $orderPositions->setOrderid($ownerData);
                $eM2->merge($orderPositions);
                $eM2->flush();
            }
        }
        $this->shoppingBasket->closeBasketSession();
        return new \Symfony\Component\HttpFoundation\Response(
           var_dump('finalised')
        );
    }

    /**
     * @Route("/shoppingbasket/transaction/delete", name="shoppingbasket_transaction_delete")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteShoppingAction(){
        $this->shoppingBasket->closeBasketSession();
        return new \Symfony\Component\HttpFoundation\Response(
            var_dump('deleted')
        );
    }
}