<?php
namespace AppBundle\Form;


use AppBundle\Service\ShoppingBasketSrvice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $shoppingBasket = new ShoppingBasketSrvice();
        $shoppingBasket->initShoppingBasket();
        $clientData = $shoppingBasket->getOwnerData();
        $builder
            ->add("name", TextType::class, ["label" => "Imię", "data" => $clientData->getName()])
            ->add("surname", TextType::class, ["label" => "Nazwisko", "data" => $clientData->getSurname()])
            ->add("adress", TextType::class, ["label" => "Adres dostawy", "data" => $clientData->getAdress()])
            ->add("phone", TextType::class, ["label" => "Numer telefonu", "data" => $clientData->getPhone()])
            ->add("additionalinfo", TextareaType::class, ["label" => "Dodatkowe informacje", "data" => $clientData->getAdditionalinfo()])
            ->add("save", SubmitType::class, ["label" => "Złóż zamówienie", "attr" => ["value" => "ssss"]])
            ->add("delete", SubmitType::class, ["label" => "Anuluj zamówienie"])
            ->add("continueshopping", SubmitType::class, ["label" => "Kontynuuj zakupy"]);

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver); // TODO: Change the autogenerated stub
    }
}