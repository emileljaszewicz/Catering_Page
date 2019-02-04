<?php
namespace AppBundle\Service;


use AppBundle\Entity\Meals;
use AppBundle\Entity\Menucategories;
use AppBundle\Entity\Orders;
use Symfony\Component\HttpFoundation\Session\Session;

class ShoppingBasketSrvice
{
    private $session = null;
    private $productsArray = [];
    private $reload;

    public function __construct()
    {
        $this->session = new Session();

    }

    public function initShoppingBasket(){
        foreach($this->getAllProducts() as $productCategory => $products) {
            foreach ($products as $productId => $productData) {
                $this->productsArray[$productCategory][$productId] = [$productData[0],$productData[1], $productData[2], $productData[3]];
            }
        }

        return $this->productsArray;
    }
    public function addProduct(Menucategories $category, Meals $product){
        $amount = 1;
        if(array_key_exists($product->getMealid(), $this->productsArray[$category->getCategoryid()])){
            $amount = $this->productsArray[$category->getCategoryid()][$product->getMealid()][2]+1;
        }

        return $this->changeProductAmount($product, $amount);
    }
    public function getAllProducts(){
        if(is_array($this->session->get('basketProducts'))) {
            return $this->session->get('basketProducts');
        }
        else{
            return [];
        }
    }

    public function changeProductAmount(Meals $product, $amount){
        if($amount > 0) {
            $this->productsArray[$product->getCategoryid()->getCategoryid()][$product->getMealid()] = [serialize($product), serialize($product->getImageid()->getHashname()), $amount, $this->calculateProductPrice($product, $amount)];
        }
        else{
            unset($this->productsArray[$product->getCategoryid()->getCategoryid()][$product->getMealid()]);
        }
        return $this->session->set('basketProducts', $this->productsArray);
    }
    public function getProductAmount(Menucategories $category, Meals $product){
        if(!empty($this->productsArray) && array_key_exists($product->getMealid(), $this->productsArray[$category->getCategoryid()])) {
            return $this->productsArray[$category->getCategoryid()][$product->getMealid()][2];
        }
        else{
            return 0;
        }
    }
    public function calculateProductPrice(Meals $product, $amount){

        return $product->getPrice()*$amount;
    }
    public function getProductsAmount(){
        $countProducts = 0;
        foreach ($this->productsArray as $productCategory => $productData){
            foreach ($productData as $product) {
                $countProducts += $product[2];
            }
        }

        return $countProducts;
    }
    public function addOwnerData(Orders $order){
        return $this->session->set('clientData', serialize($order));
    }
    public function getOwnerData(){
        if(!empty($this->session->get('clientData'))){
            return unserialize($this->session->get('clientData'));
        }
        else{
            $order = new Orders();
            return $order;
        }
    }
}