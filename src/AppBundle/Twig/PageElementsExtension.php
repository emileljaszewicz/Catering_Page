<?php
namespace AppBundle\Twig;


use AppBundle\Entity\Messagescustomers;

class PageElementsExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter("createMessageField", [$this, "createMessageField"]),
            new \Twig_SimpleFilter("countOfProducts", [$this, "countOfProducts"]),
            new \Twig_SimpleFilter("unserialize", [$this, "dataUnserialize"]),
        );
    }
    public function createMessageField(Messagescustomers $message){
        if($message->getReceived() == 0){
            return "new-message";
        }
        else{
            return "message-received";
        }
    }
    public function countOfProducts($products){
        $countOfProducts = null;
        if(is_array($products)) {
            foreach ($products as $category => $productsList) {
                foreach ($productsList as $product) {
                    $countOfProducts += $product[2];
                }

            }
        }
        return $countOfProducts;
    }

    public function dataUnserialize($serialized){
        return unserialize($serialized);
    }

}