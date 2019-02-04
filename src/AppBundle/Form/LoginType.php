<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 2018-06-16
 * Time: 16:15
 */

namespace AppBundle\Form;


use AppBundle\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add("_username", TextType::class, ["label" => "Podaj login"])
           ->add("_password", TextType::class, ["label" => "Podaj hasło"])
           ->add("submit", SubmitType::class, ["label" => "Zapisz"]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(["data_class" => Users::class]);
    }
}