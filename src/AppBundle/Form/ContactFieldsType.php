<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 10.09.2018
 * Time: 11:56
 */

namespace AppBundle\Form;


use AppBundle\Entity\Contactinformation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFieldsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("contactposition", TextType::class, ["label" => "Nazwa pola"])
            ->add("contactdetails", TextType::class, ["label" => "Zawartość pola"])
            ->add("submit", SubmitType::class, ["label" => "zapisz"]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Contactinformation::class,
        ]);
    }
}