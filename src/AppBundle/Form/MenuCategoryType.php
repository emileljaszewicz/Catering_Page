<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 11.09.2018
 * Time: 13:54
 */

namespace AppBundle\Form;


use AppBundle\Entity\Menucategories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add("categoryname", TextType::class, ["label" => "Nagłówek"])
            ->add("categorydescription", TextareaType::class, ["label" => "Opis"])
            ->add('imageid', EntityType::class, [
                'class' => 'AppBundle:Images',
                'choice_label' => 'imgname',
                'label' => 'Zdjęcie z bazy',])
            ->add("submit", SubmitType::class, ["label" => "Zapisz"])
            ->add("remove", SubmitType::class, ["label" => "Usuń"]);
    }
    public function configureOptions(OptionsResolver$resolver)
    {
        $resolver->setDefaults(["data_class" => Menucategories::class]);
    }
}