<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 07.09.2018
 * Time: 17:04
 */

namespace AppBundle\Form;


use AppBundle\Entity\Images;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("imgname", FileType::class, ["label" => "Dodaj zdjęcie"])
            ->add("submit", SubmitType::class, ["label" => "Zapisz"]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Images::class,
        ]);
    }
}