<?php

namespace AppBundle\Form;


use AppBundle\Entity\Users;
use function Sodium\add;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("username", TextType::class, ["label" => "Login"])
            ->add("email", EmailType::class, ["label" => "Email"])
            ->add("phonenumber", NumberType::class, ["label" => "Telefon"])
            ->add("name", TextType::class, ["label" => "Imię"])
            ->add("surname", TextType::class, ["label" => "Nazwisko"])
            ->add('submit', SubmitType::class, ["label" => "Zapisz"]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Users::class,
        ]);
    }
}