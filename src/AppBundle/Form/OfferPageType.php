<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 08.09.2018
 * Time: 19:13
 */

namespace AppBundle\Form;


use AppBundle\Entity\Pagedescription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferPageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title", TextType::class, ["label" => "Tytuł strony"])
            ->add("description", TextareaType::class, ["label" => "Opis strony"])
            ->add("submit", SubmitType::class, ["label" => "Zapisz"]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults([
           "data_class" => Pagedescription::class,
           ]
       );
    }

}